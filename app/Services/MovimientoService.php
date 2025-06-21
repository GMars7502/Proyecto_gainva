<?php

namespace App\Services;

use App\Models\Insumos;
use App\Models\MovimientoAlmacen;
use App\Models\Almacen; // Tu modelo de stock consolidado
use App\Models\ControlCebado; // Si necesitas el modelo de ControlCebado
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Exceptions\ValidationException as CustomValidationException;
use Exception;

class MovimientoService
{


    #region 🥸 VARIADOS 
    /**
     * Obtiene el stock consolidado para un insumo/zona/lote en un período específico.
     */
    protected function obtenerStockConsolidado(int $insumoId, string $zona, ?string $lote, Carbon $fechaDelMovimiento): int
    {
        $periodoBuscado = $fechaDelMovimiento->copy()->startOfMonth();

        $query = Almacen::where('idInsumo', $insumoId) 
                         ->where('zona', $zona)        
                         ->where('fecha_guardado', $periodoBuscado);

        if ($lote) {
            $query->where('lote', $lote);
        } else {
            $query->whereNull('lote'); // Estándar para "sin lote"
        }

        $stockEntry = $query->first();
        // Asumiendo que la columna de stock se llama 'stock_consolidado'
        $currentStock = $stockEntry ? (int)$stockEntry->cant_stock : 0;

        Log::debug("[obtenerStockConsolidado] Stock para {$insumoId}/{$zona}/".($lote ?? 'SIN_LOTE')."/{$periodoBuscado->toDateString()}: {$currentStock}");
        return $currentStock;
    }











    /**
     * Actualiza (o crea) el registro de stock consolidado.
     */
    protected function actualizarStockConsolidado(int $insumoId, string $zona, ?string $lote, int $cantidadMovida, string $tipoMovimiento, Carbon $fechaDelMovimiento): int
    {
        $periodoActualizar = $fechaDelMovimiento->copy()->startOfMonth();

        $attributes = [
            'idInsumo' => $insumoId,
            'zona' => $zona,
            'fecha_guardado' => $periodoActualizar,
            'lote' => $lote // Será null si $lote es null, buscando/creando con lote null
        ];

        // Busca o crea el registro para el mes/insumo/zona/lote
        // Si no existe, se crea con stock_consolidado = 0 (definido en el segundo parámetro de firstOrCreate)
        $stockEntry = Almacen::firstOrCreate($attributes, ['cant_stock' => 0]);

        if ($tipoMovimiento === 'entrada') {
            $stockEntry->cant_stock += $cantidadMovida;
        } else { // salida
            // La validación de stock suficiente ya ocurrió antes de llamar a esta función
            $stockEntry->cant_stock -= $cantidadMovida;
        }

        $stockEntry->save();
        $newStockLevel = $stockEntry->cant_stock;

        Log::info("[actualizarStockConsolidado] Stock actualizado para {$insumoId}/{$zona}/".($lote ?? 'SIN_LOTE')."/{$periodoActualizar->toDateString()}: {$newStockLevel}");
        return $newStockLevel;
    }

    #endregion







    #region 🍔 CREATE 
    public function registrarNuevosMovimientos(array $movimientosData, int $insumoId, string $almacenNombre): array
    {
        Log::info("[MovimientoService@registrarNuevosMovimientos] Iniciando.", compact('insumoId', 'almacenNombre'));

        if (empty($movimientosData)) {
            throw new CustomValidationException('No se proporcionaron datos de movimientos para registrar.', []);
        }

        $insumoActual = Insumos::findOrFail($insumoId);
        $loteRequeridoParaInsumo = ($insumoActual->control_cebado === 'Y' || $insumoActual->control_cebado == 1);

        $erroresDeValidacion = [];
        $movimientosParaCrearEnDB = [];
        $idsMovimientosCreados = [];
        $stockTemporal = []; // Para simular el stock DENTRO del lote de movimientos actual

        // DB::beginTransaction(); // La transacción se mueve para después de la validación del lote completo
        // try { // El try general también se moverá

            $anoActual = Carbon::now()->year;
            $mesActual = Carbon::now()->month;
            Log::info("[MovimientoService] Validando contra Mes/Año actual: {$mesActual}/{$anoActual}");

            foreach ($movimientosData as $index => $dataMovimiento) {
                Log::debug("[MovimientoService] Validando movimiento #{$index}:", $dataMovimiento);

                $loteDelMovimiento = $dataMovimiento['lote'] ?? null; // Lote específico de este movimiento
                // Lote es requerido si el insumo general lo requiere.
                $loteEsRequeridoEsteMovimiento = $loteRequeridoParaInsumo;

                $reglasBase = [ /* ... tus reglas ... */
                    'fecha' => 'required|date_format:Y-m-d',
                    'cant_movida' => 'required|integer|min:1',
                    'tipo_movimiento' => 'required|in:entrada,salida',
                    'observacion' => 'required|string|max:255',
                    'lote' => $loteEsRequeridoEsteMovimiento ? 'required|string|max:100' : 'nullable|string|max:100',
                ];
                if (isset($dataMovimiento['tipo_movimiento']) && $dataMovimiento['tipo_movimiento'] === 'entrada') {
                    $reglasBase['proveedor'] = 'required|string|max:100';
                    $reglasBase['factu_o_boleta'] = 'required|string|max:100';
                }

                $validador = Validator::make($dataMovimiento, $reglasBase);
                if ($validador->fails()) {
                    $erroresDeValidacion["movimiento_{$index}_val_base"] = $validador->errors()->all();
                    Log::warning("[MovimientoService] Falla validación base mov #{$index}", $validador->errors()->all());
                    continue;
                }

                $fechaMovimiento = Carbon::parse($dataMovimiento['fecha']);
                if ($fechaMovimiento->year !== $anoActual || $fechaMovimiento->month !== $mesActual) {
                    $msgErrorFecha = "La fecha (".$fechaMovimiento->format('d/m/Y').") debe ser del mes y año actual ({$mesActual}/{$anoActual}).";
                    $erroresDeValidacion["movimiento_{$index}_fecha_actual"] = [$msgErrorFecha];
                    Log::warning("[MovimientoService] Falla validación mes/año mov #{$index}. {$msgErrorFecha}");
                    continue;
                }

                // Clave para el stock temporal (incluye el lote si es relevante)
                // Usamos 'SIN_LOTE_EXPLICITO' si $loteDelMovimiento es null para clave de array consistente
                $loteParaClaveTemporal = $loteDelMovimiento ?: '___SIN_LOTE_PLACEHOLDER___';
                $keyStockTemporal = $insumoId . '|' . $almacenNombre . '|' . $loteParaClaveTemporal;

                // Inicializar stock temporal si es la primera vez que vemos esta combinación en el LOTE ACTUAL
                if (!array_key_exists($keyStockTemporal, $stockTemporal)) {
                    // El lote que se pasa a obtenerStockConsolidado debe ser null si no hay lote, no el placeholder.
                    $stockTemporal[$keyStockTemporal] = $this->obtenerStockConsolidado(
                        $insumoId,
                        $almacenNombre,
                        $loteDelMovimiento, // Pasar el lote real (puede ser null)
                        $fechaMovimiento // Para obtener el stock del período correcto
                    );
                    Log::info("[MovimientoService] Stock consolidado inicial para clave '{$keyStockTemporal}': " . $stockTemporal[$keyStockTemporal]);
                }

                $cantidadSolicitada = (int)$dataMovimiento['cant_movida'];
                $stockDisponibleTemporal = $stockTemporal[$keyStockTemporal];

                if ($dataMovimiento['tipo_movimiento'] === 'salida') {
                    Log::debug("[MovimientoService] Validando Salida #{$index}. Clave: {$keyStockTemporal}. Sol: {$cantidadSolicitada}. Disp_Temp: {$stockDisponibleTemporal}");
                    if ($cantidadSolicitada > $stockDisponibleTemporal) {
                        $msgErrorStock = "Stock insuficiente (simulado en lote) para salida #{$index} de {$insumoActual->Nombre} ".($loteDelMovimiento ? "Lote: {$loteDelMovimiento}" : "").". Disp_Temp: {$stockDisponibleTemporal}, Sol: {$cantidadSolicitada}.";
                        $erroresDeValidacion["movimiento_{$index}_stock_simulado"] = [$msgErrorStock];
                        Log::warning("[MovimientoService] " . $msgErrorStock);
                        continue;
                    }
                    $stockTemporal[$keyStockTemporal] -= $cantidadSolicitada; // Actualizar stock temporal para la siguiente iteración del lote
                } else { // entrada
                    $stockTemporal[$keyStockTemporal] += $cantidadSolicitada; // Actualizar stock temporal para la siguiente iteración del lote
                }
                Log::info("[MovimientoService] Stock temporal actualizado para '{$keyStockTemporal}' tras mov #{$index}: " . $stockTemporal[$keyStockTemporal]);

                $movimientosParaCrearEnDB[] = $dataMovimiento;
            } // Fin del bucle de validación

            if (!empty($erroresDeValidacion)) {
                // No necesitamos DB::rollBack() aquí porque la transacción aún no ha comenzado para las escrituras.
                Log::warning("[MovimientoService] Fallaron las validaciones pre-transacción. Errores:", $erroresDeValidacion);
                throw new CustomValidationException('Algunos movimientos tienen errores y no se guardó ningún movimiento.', $erroresDeValidacion);
            }

           
            DB::beginTransaction();
            try {
                foreach ($movimientosParaCrearEnDB as $dataMov) {
                    $movimientoGuardado = MovimientoAlmacen::create([
                        'fk_insumos'      => $insumoId,
                        'almacen'         => $almacenNombre,
                        'tipo_movimiento' => $dataMov['tipo_movimiento'],
                        'fecha'           => $dataMov['fecha'],
                        'cant_movida'     => $dataMov['cant_movida'],
                        'factu_o_boleta'  => $dataMov['factu_o_boleta'] ?? null,
                        'observacion'     => $dataMov['observacion'],
                        'lote'            => $dataMov['lote'], // Puede ser null si no es requerido y no se proveyó
                        'proveedor'       => $dataMov['proveedor'] ?? null,
                    ]);
                    $idsMovimientosCreados[] = $movimientoGuardado->idMovimiento;

                    

                    //**
                        //  AQUI SE REALIZAR LA LOGICA PARA GUARDAR EL CONTROL DE CEBADO 
                        // Se debería crear un metodo propio para esto, pero por ahora lo dejamos aquí 20.06.2025
                        // 
                        //  */


                    if($dataMov['tipo_movimiento'] === 'salida' && $loteRequeridoParaInsumo && str_contains($dataMov['observacion'], '(I-II-III)')){



                        log::info("Entrado a la lógica de control de cebado :VVV ");

                        $siguienteFecha = Carbon::parse($dataMov['fecha'])->addDay();

                        // Si el siguiente día es sábado, saltar al lunes (sumar 2 días más)
                        if ($siguienteFecha->isSunday()) {
                            $siguienteFecha->addDays(1);
                        }

                        log::info("Despues de ingresar la fecha, Aqui se ingresar ene el query");



                        // Insertar logíca para seleccionar el parametro lote1, lote2, lote3, etc.
                        $query = ControlCebado::where('fk_insumos', $insumoId)
                            ->where('actualFecha', '<=', $dataMov['fecha'])
                            ->orderBy('actualFecha', 'desc')
                            ->orderBy('idControl', 'desc');
                        

                        $arrayQuery =  $query->get()->toArray();

                                    log::info("Total de registros en el arrayQuery: " . count($arrayQuery));
                                    log::info("Valor del arrayQuery: " . json_encode($arrayQuery));

                        $primerDataControlCebado = $query->first();

                        
                        

                        $LoteFinal = $dataMov['lote'];
                        $CantFinal = $dataMov['cant_movida'];

                        log::info("Lote Final: {$LoteFinal}, Cantidad Final: {$CantFinal}");

                        

                        if($primerDataControlCebado == null){
                            log::info("el primerDataControlCebado es nulo, se poner con un valor de 1 la posicion");
                            $numeroDePosicion = 1;
                        }
                        else{

                            $numeroDePosicion = 1;
                            $loteActual = null;


                            log::info("Entado al else del primerDataControlCebado, entrado al primer for");

                            for ($i=1; $i <= 4 ; $i++) { 
                                if ($primerDataControlCebado->{'lote' . $i} != null) {
                                    $loteActual = $primerDataControlCebado->{'lote' . $i};
                                    $numeroDePosicion = $i;

                                    log::info("Lote actual encontrado: {$loteActual} en la posición {$numeroDePosicion}");
                                    break;

                                }
                            }


                            if ($loteActual !== $LoteFinal){

                                log::info("Se entró ya que no coincide los lotes actual y final");
                                
                                for ($i= 1; $i <= 4 ; $i++) {

                                    $numeroDePosicion = $i;

                                   log::info("Entrado al segundo for con disminución");


                                    Log::info("Número de posición inicial: " . $numeroDePosicion);

                                    $posicionLoteSinContenido = True;

                                    foreach ($arrayQuery as $key => $value) {
                                        log::info("Entrado al foreach de los valores del query");

                                        $keyLote = 'lote' . $i;

                                        $valorLote = $value[$keyLote] ?? null;

                                        

                                        log::info("Valor del lote en la posición {$i}: {$valorLote}");

                                        if (is_null($valorLote)) {
                                            log::info("es nulo el valor lote");

                                            $posicionLoteNoVacio = True;
                                        }else {
                                            $posicionLoteNoVacio = False;
                                        }


                                        if(!$posicionLoteNoVacio)
                                        {
                                            $posicionLoteSinContenido = False;

                                            log::info("Entrado al for de los lotes, se verifica si el lote {$valorLote} es igual al lote final {$LoteFinal}");

                                            if ($valorLote  === $LoteFinal){
                                                $numeroDePosicion = $i;
                                                log::info("Lote encontrado en posición {$numeroDePosicion} con lote {$LoteFinal}");
                                


                                                break 2;

                                            }
                                            else {
                                                log::info("Lote no encontrado en la posición {$i}, se sigue buscando");
                                            }
                                        }    
                                    }

                                    if ($posicionLoteSinContenido) {
                                        log::info("Se encontró una posición vacía en lote {$i}, se asignará el lote final {$LoteFinal} aquí.");
                                        $numeroDePosicion = $i;
                                        break;
                                    }




                                }
                            }




                        }


                        if ($numeroDePosicion > 4) {
                            Log::warning("Posición mayor a 4 detectada, se usará la posición 4.");
                            $numeroDePosicion = 4;
                        }
                        
                        $dataCebado = [
                            'fk_insumos' => $insumoId,
                            'actualFecha' => $dataMov['fecha'],
                            'siguienteFecha' => $siguienteFecha,
                            'status' => 'N',
                        ];

                        $dataCebado['lote' . $numeroDePosicion] = $LoteFinal;
                        $dataCebado['cant' . $numeroDePosicion] = $CantFinal;

                        ControlCebado::create($dataCebado);




                    }






                    
                    $this->actualizarStockConsolidado(
                        $insumoId,
                        $almacenNombre,
                        $dataMov['lote'],
                        $dataMov['cant_movida'],
                        $dataMov['tipo_movimiento'],
                        Carbon::parse($dataMov['fecha'])
                    );
                }
                DB::commit();
                Log::info("[MovimientoService] Transacción completada. IDs Creados: " . implode(', ', $idsMovimientosCreados));
                return $idsMovimientosCreados;

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("EXCEPCIÓN durante la CREACIÓN en MovimientoService:", ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
                throw new Exception('Error interno al guardar los movimientos (fase de creación): ' . $e->getMessage());
            }

    }

    #endregion













    #region 😯 UPDATE 


    
    
    public function actualizarUnMovimiento(int $movimientoId, array $datosNuevos): MovimientoAlmacen
    {
        Log::info("[MovimientoService@actualizarUnMovimiento] Iniciando para Movimiento ID: {$movimientoId}", $datosNuevos);

        DB::beginTransaction();
        try {
            $movimiento = MovimientoAlmacen::findOrFail($movimientoId);
            $insumo = Insumos::findOrFail($movimiento->fk_insumos); // fk_insumos debe ser el campo correcto

            $loteRequeridoParaInsumo = ($insumo->control_cebado === 'Y');

            // --- Validación de los datos nuevos ---
            $reglasValidacion = [
                'fecha' => 'required|date_format:Y-m-d',
                'cant_movida' => 'required|integer|min:1',
                'observacion' => 'required|string|max:255',
                'lote' => ($loteRequeridoParaInsumo && $movimiento->tipo_movimiento === 'entrada') ? 'required|string|max:100' : 'nullable|string|max:100',
                // El lote es requerido para salidas si el insumo lo es, pero podría no ser editable si la salida ya lo consumió.
                // Por simplicidad, si es salida y el insumo es control_cebado, y se provee un lote, se actualiza.
                // Si es salida y no se provee lote, pero el original tenía, se mantiene el original (o se valida que se provea).
                // Aquí, para edición, si el lote es requerido por el insumo (control_cebado), lo hacemos editable y requerido si es entrada. 
                // Para salidas, si el insumo es control_cebado, el lote original no debería cambiar si es un ajuste de cantidad sobre el mismo lote.
                // Si se permite cambiar el lote en una salida editada, la lógica de stock se complica más.
                // Por ahora, si es requerido por el insumo, lo validamos.
            ];

            if ($movimiento->tipo_movimiento === 'entrada') {
                $reglasValidacion['proveedor'] = 'required|string|max:100';
                $reglasValidacion['factu_o_boleta'] = 'required|string|max:50';
            }

            $validador = Validator::make($datosNuevos, $reglasValidacion);
            if ($validador->fails()) {
                throw new CustomValidationException('Errores de validación al actualizar movimiento.', $validador->errors()->all());
            }

            $datosValidados = $validador->validated(); // Solo los datos que pasaron la validación

            $fechaOriginal = Carbon::parse($movimiento->fecha);
            $fechaNueva = Carbon::parse($datosValidados['fecha']);


            $anoActual = Carbon::now()->year;
            $mesActual = Carbon::now()->month;
            if ($fechaNueva->year !== $anoActual || $fechaNueva->month !== $mesActual) {
                 throw new CustomValidationException('La fecha del movimiento debe ser del mes y año actual.', [
                    'fecha' => ["La fecha (".$fechaNueva->format('d/m/Y').") debe ser del mes y año actual ({$mesActual}/{$anoActual})."]
                 ]);
            }

            // Validación de Fecha: No puede cambiar de mes/año
            

            if ($fechaNueva->year !== $fechaOriginal->year || $fechaNueva->month !== $fechaOriginal->month) {
                throw new CustomValidationException('La edición de la fecha no puede cambiar el mes o el año del movimiento original.', [
                    'fecha' => ["La edición de la fecha solo puede ser dentro del mes y año original ({$fechaOriginal->format('m/Y')})."]
                ]);
            }
             
            // --- Lógica de Stock ---
            $cantidadOriginal = (int)$movimiento->cant_movida;
            $cantidadNueva = (int)$datosValidados['cant_movida'];
            $diferenciaCantidad = $cantidadNueva - $cantidadOriginal;

            // Lote a usar para el stock consolidado (el original o el nuevo si se permite cambiar y se provee)
            // Si el lote es un campo editable en $datosValidados, usar ese. Si no, usar el original.
            $loteParaStock = $datosValidados['lote'] ?? $movimiento->lote;
            if ($loteRequeridoParaInsumo && empty($loteParaStock)) { // Si es requerido y termina vacío, error.
                 throw new CustomValidationException('El lote es requerido para este insumo y no puede estar vacío en la edición.', ['lote' => ['El lote es obligatorio.']]);
            }


            // Si es una SALIDA y la nueva cantidad es MAYOR, o si es una ENTRADA y la nueva cantidad es MENOR,
            // necesitamos verificar el stock.
            // El caso más simple es si el stock consolidado actual menos el *impacto neto* de la salida es < 0.
            if ($movimiento->tipo_movimiento === 'salida') {
                // Se obtiene el stock consolidado ANTES de aplicar cualquier cambio de esta edición
                $stockConsolidadoActual = $this->obtenerStockConsolidado(
                    $movimiento->fk_insumos,
                    $movimiento->almacen, // zona
                    $loteParaStock,       // Usar el lote que se va a guardar (original o nuevo)
                    $fechaOriginal        // El período de stock es el del movimiento original
                );

                // El stock después de revertir el efecto original de esta salida sería:
                // $stockSiSeRevierteSalidaOriginal = $stockConsolidadoActual + $cantidadOriginal;
                // El nuevo stock después de aplicar la nueva salida sería:
                // $stockDespuesDeNuevaSalida = $stockSiSeRevierteSalidaOriginal - $cantidadNueva;

                // O más directo: el stock actual menos el *nuevo* débito de esta salida, más el *viejo* crédito de esta salida
                $stockProyectado = $stockConsolidadoActual + $cantidadOriginal - $cantidadNueva;

                if ($stockProyectado < 0) {
                    throw new CustomValidationException('La modificación resulta en stock insuficiente.', [
                        'cant_movida' => ["Stock insuficiente. Actual: {$stockConsolidadoActual}, se intenta sacar {$cantidadNueva} (antes {$cantidadOriginal}). Proyectado: {$stockProyectado}"]
                    ]);
                }
            }

            // Actualizar el registro de MovimientoAlmacen
            // Solo actualizamos los campos que están en $datosValidados para no sobrescribir otros por error
            $movimiento->fill($datosValidados); // fill() solo asignará atributos presentes en $fillable del modelo
            $movimiento->save();

            // Actualizar el stock consolidado en la tabla AlmacenStock
            // La cantidad neta que cambia en el stock consolidado es $diferenciaCantidad.
            // Si es entrada, un aumento en cant_movida aumenta el stock. Una disminución, lo disminuye.
            // Si es salida, un aumento en cant_movida disminuye el stock. Una disminución, lo aumenta.

            $impactoNetoEnStock = 0;
            if ($movimiento->tipo_movimiento === 'entrada') {
                $impactoNetoEnStock = $diferenciaCantidad; // ej. antes 5, ahora 8. dif=3. stock+=3
            } else { // salida
                $impactoNetoEnStock = -$diferenciaCantidad; // ej. antes 5, ahora 8. dif=3. stock-=3
            }

            // Re-obtenemos y actualizamos el stock consolidado.
            // Usamos la fecha original del movimiento para identificar el periodo correcto en AlmacenStock.
            $periodoStock = $fechaOriginal->copy()->startOfMonth();
            $atributosStock = [
                'idInsumo' => $movimiento->fk_insumos,
                'zona' => $movimiento->almacen,
                'fecha_guardado' => $periodoStock,
                'lote' => $loteParaStock // Usar el lote que finalmente tendrá el movimiento
            ];
            $stockEntry = Almacen::firstWhere($atributosStock);

            if ($stockEntry) {
                $stockEntry->cant_stock += $impactoNetoEnStock;
                $stockEntry->save();
                Log::info("[MovimientoService@actualizarUnMovimiento] Stock consolidado actualizado para {$movimiento->fk_insumos}/{$movimiento->almacen}/{$loteParaStock}/{$periodoStock->toDateString()}: {$stockEntry->cant_stock}");
            } else {
                // Esto sería un caso raro si el movimiento existía, el stock consolidado debería existir.
                // Podría pasar si se borró manualmente la entrada de AlmacenStock.
                // O si se cambia el lote a uno que no tenía registro de stock.
                Log::error("[MovimientoService@actualizarUnMovimiento] No se encontró registro en AlmacenStock para actualizar. Creando uno nuevo.", $atributosStock);
                // Creamos uno nuevo, el stock sería el impacto de este movimiento
                if ($movimiento->tipo_movimiento === 'entrada') {

                    $nuevoStockCalculado = $datosValidados['cant_movida'];
                    
                    Almacen::create([
                        'insumo_id' => $movimiento->fk_insumos,
                        'zona' => $movimiento->almacen,
                        'fecha_guardado' => $periodoStock,
                        'lote' => $loteParaStock,
                        'cant_stock' => $nuevoStockCalculado // Stock inicial basado solo en este movimiento editado
                    ]);
                    Log::info("[MovimientoService@actualizarUnMovimiento] Creada nueva entrada en AlmacenStock por edición. Stock: {$nuevoStockCalculado}");  } 
                 
                 else{

                     throw new CustomValidationException('No se encontró el resgistro de la salida con los parametros
                     necesarios');

                 }
            }

            DB::commit();
            Log::info("[MovimientoService@actualizarUnMovimiento] Movimiento ID {$movimientoId} actualizado con éxito.");
            return $movimiento->fresh(); // Devolver el modelo actualizado

        } catch (CustomValidationException $e) {
            DB::rollBack();
            Log::warning("[MovimientoService@actualizarUnMovimiento] Error de validación para Mov ID {$movimientoId}: " . $e->getMessage(), $e->getErrors());
            throw $e; // Relanzar para que el controlador la maneje
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            Log::error("[MovimientoService@actualizarUnMovimiento] Modelo no encontrado (Movimiento o Insumo) para Mov ID {$movimientoId}. " . $e->getMessage());
            throw new Exception("Recurso no encontrado durante la actualización."); // O una excepción más específica
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("EXCEPCIÓN GENERAL en MovimientoService@actualizarUnMovimiento para Mov ID {$movimientoId}:", [
                'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()
            ]);
            throw new Exception('Error interno al actualizar el movimiento: ' . $e->getMessage());
        }
    }

    #endregion











    #region 😵 DELETE

    public function eliminarUnMovimiento(int $movimientoId): bool
    {
        Log::info("[MovimientoService@eliminarUnMovimiento] Iniciando para Movimiento ID: {$movimientoId}");

        DB::beginTransaction();
        try {
            $movimiento = MovimientoAlmacen::findOrFail($movimientoId);

            // --- Validación de Fecha: Solo se pueden eliminar movimientos del mes y año actual ---
            $fechaMovimiento = Carbon::parse($movimiento->fecha);
            $anoActual = Carbon::now()->year;
            $mesActual = Carbon::now()->month;

            if ($fechaMovimiento->year !== $anoActual || $fechaMovimiento->month !== $mesActual) {
                DB::rollBack(); // No es estrictamente necesario aquí, pero por si acaso
                $mensajeErrorFecha = "Solo se pueden eliminar movimientos del mes y año actual ({$mesActual}/{$anoActual}). Fecha del movimiento: ".$fechaMovimiento->format('d/m/Y');
                Log::warning("[MovimientoService@eliminarUnMovimiento] {$mensajeErrorFecha}");
                throw new CustomValidationException($mensajeErrorFecha, ['fecha' => [$mensajeErrorFecha]]);
            }

            $insumoId = $movimiento->fk_insumos; // Asegúrate que sea el nombre correcto de la columna
            $almacenNombre = $movimiento->almacen; // Asegúrate que sea el nombre correcto de la columna
            $loteDelMovimiento = $movimiento->lote;
            $cantidadOriginal = (int)$movimiento->cant_movida;
            $tipoOriginal = $movimiento->tipo_movimiento;

            // --- Ajustar el Stock Consolidado ---
            // Para revertir el efecto del movimiento en el stock consolidado:
            // Si era una 'entrada', ahora restamos (es como una 'salida' del consolidado).
            // Si era una 'salida', ahora sumamos (es como una 'entrada' al consolidado).
            $tipoAjusteParaStock = ($tipoOriginal === 'entrada') ? 'salida' : 'entrada';

            // Llamamos a actualizarStockConsolidado para revertir el efecto.
            // La función actualizarStockConsolidado ya maneja si la entrada en AlmacenStock existe o no.
            // Es importante que esta función no falle si el stock se vuelve negativo,
            // ya que estamos "devolviendo" items. Sin embargo, si la lógica de negocio
            // no permite stock negativo en AlmacenStock NUNCA, esto podría ser un problema.
            // Por ahora, asumimos que AlmacenStock puede reflejar el estado después de la anulación.
            $this->actualizarStockConsolidado(
                $insumoId,
                $almacenNombre,
                $loteDelMovimiento,
                $cantidadOriginal,         // La cantidad del movimiento que se elimina
                $tipoAjusteParaStock,      // El tipo de ajuste INVERSO al original
                $fechaMovimiento           // La fecha del movimiento para el período correcto
            );

            // --- Eliminar el Registro del Movimiento ---
            $movimiento->delete();

            DB::commit();
            Log::info("[MovimientoService@eliminarUnMovimiento] Movimiento ID {$movimientoId} eliminado y stock consolidado ajustado con éxito.");
            return true;

        } catch (CustomValidationException $e) {
            // DB::rollBack(); // Ya se hizo rollback o no se inició si la validación fue antes.
            Log::warning("[MovimientoService@eliminarUnMovimiento] Error de validación para Mov ID {$movimientoId}: " . $e->getMessage(), $e->getErrors());
            throw $e; // Relanzar para que el controlador la maneje
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            Log::error("[MovimientoService@eliminarUnMovimiento] Movimiento ID {$movimientoId} no encontrado. " . $e->getMessage());
            throw $e; // Relanzar para que el controlador la maneje
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("EXCEPCIÓN GENERAL en MovimientoService@eliminarUnMovimiento para Mov ID {$movimientoId}:", [
                'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()
            ]);
            throw new Exception('Error interno al eliminar el movimiento: ' . $e->getMessage());
        }
    }

    

    #endregion





}