<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\MovimientoAlmacen;
use App\Models\Insumos; // Asegúrate que el namespace es correcto
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // Asegúrate de importar Carbon
use Illuminate\Support\Facades\Validator;

    /*








    Se dejo de utilizar:
    Este componente se utilizaba para mostrar los registros de cada Insumo 
    pero se dejo de utilizar por lentitud en la carga de datos.












    **/


class KarnessRegistro extends Component
{
    // Propiedades existentes que mantenemos
    public $insumoId;
    public $almacen;
    public $anio;
    public $mes;
    public $karness; // Id del karness actual
    public $insumos = []; // Colección de Insumos para navegación
    public $indiceActual = 0;

    // Propiedades para el modal de borrado
    public $showConfirmDeleteModal = false;
    public $movementIdToDelete = null;

    // Propiedad para el modal de creacion
    public $showCreateModal = false;
    public $createModalTab = 'entradas';
    //public $numeroSalidas = 1; // Número de filas de salida a mostrar
    public $salidasData = [];  // Array para los datos de las filas de salida
    public $loteIsRequired = false; // Flag para saber si el lote es obligatorio
    // *********************************************

    // Propiedad para almacenar los movimientos a mostrar en la tabla
    // Ya no será un array keyBy->toArray, sino una colección Eloquent
    public $movimientos; // No necesita ser public si solo se usa en render? Revisar. Dejémosla public por ahora.

    


    public function mount($almacen, $insumoId) // Fecha no se usa, podemos quitarla si quieres
    {
        $this->almacen = $almacen;
        $this->insumoId = $insumoId;

        // Inicializar filtros con el mes y año actual si no vienen dados
        $this->anio = $this->anio ?? date('Y');
        $this->mes = $this->mes ?? date('n');

        // Carga inicial
        $this->cargarInsumos(); // Carga la lista de insumos para la navegación y establece indiceActual
        $this->cargarMovimientos(); // Carga los movimientos del insumo actual para el mes/año actual
    }

    // El método render ahora simplemente devuelve la vista.
    // Pasará las propiedades públicas automáticamente.
    public function render()
    {
        // Ya no necesitamos pasar $movimientos manualmente si es public
        // Si la hiciéramos protected, aquí la pasaríamos:
        // return view('livewire.components.karness-registro', [
        //     'movimientos' => $this->movimientos
        // ]);
        return view('livewire.components.karness-registro');
    }

    // -------------------------------------------------------------------------
    // Métodos de Carga de Datos (Mantenemos y ajustamos)
    // -------------------------------------------------------------------------

    #region cargaInsumos

    public function cargarMovimientos()
    {
        // Carga los movimientos como una colección Eloquent, ordenada por fecha y luego ID
        // Ya no usamos keyBy()->toArray() porque no necesitamos el array para wire:model
        $this->movimientos = MovimientoAlmacen::where('fk_insumos', $this->insumoId)
            ->whereYear('fecha', $this->anio)
            ->whereMonth('fecha', $this->mes)
            ->orderBy('fecha', 'asc') // Importante ordenar cronológicamente
            ->orderBy('idMovimiento', 'asc') // Desempate por ID
            ->get();

        // Aquí eventualmente llamaremos a la función que recalcula el stock visual
        // $this->recalcularStockVisual(); // (A implementar)

        // Log para ver cuántos movimientos se encontraron
    $count = $this->movimientos->count();
    Log::debug("Número de movimientos encontrados del {$this->insumoId}: {$count}");
    }

    public function cargarInsumos()
    {
        // Buscamos el insumo actual para obtener su karness ID
        $insumoActual = Insumos::find($this->insumoId);
        if (!$insumoActual) {
            // Manejar error si el insumo no existe? Redirigir?
            // Por ahora, cargamos una lista vacía para evitar errores.
            Log::warning("Insumo con ID {$this->insumoId} no encontrado en cargarInsumos.");
            $this->insumos = collect();
            $this->karness = null;
            $this->indiceActual = 0;
            return;
        }
        $this->karness = $insumoActual->idKarness; // Asumiendo que el campo FK se llama idKarness

        // Preparamos la query base para buscar insumos del mismo karness
        $query = Insumos::where('idKarness', $this->karness);

        // Aplicamos filtro según el almacén seleccionado ('Principal', 'Secundario', 'Total')
        if ($this->almacen === 'Principal') {
            $query->where('almacenPrincipal', 'Y');
        } elseif ($this->almacen === 'Secundario') {
            $query->where('almacenSegundo', 'Y');
        }
        // No necesitamos el caso 'Total', ya que al no filtrar por almacenPrincipal/Segundo,
        // where('idKarness', ...) ya trae todos los de ese Karness.
        // Si la lógica fuera diferente (ej. un insumo puede estar SÓLO en uno),
        // el 'Total' requeriría orWhere como tenías antes, pero asumo que
        // un insumo pertenece a un Karness y puede estar en P, S o ambos.

        // Obtenemos la colección de insumos ordenada por el id del insumo
        // values() resetea las keys para que sean 0, 1, 2...
        $this->insumos = $query->orderBy('idInsumo')->get()->values();

        // Encontramos el índice del insumo actual en la colección cargada
        // Usamos search() que devuelve el índice (key) o false si no lo encuentra
        $indice = $this->insumos->search(fn($i) => $i->idInsumo == $this->insumoId);
        $this->indiceActual = ($indice !== false) ? $indice : 0;

        // Log::info("Insumos cargados para Karness {$this->karness} y Almacén {$this->almacen}. Actual: {$this->insumoId} en índice {$this->indiceActual}");

    }

    #endregion


    #region Navegacion
    // -------------------------------------------------------------------------
    // Métodos de Navegación (Mantenemos como estaban)
    // -------------------------------------------------------------------------

    public function siguiente()
    {
        if ($this->indiceActual < count($this->insumos) - 1) {
            $this->indiceActual++;
            $this->insumoId = $this->insumos[$this->indiceActual]->idInsumo;
            $this->cargarMovimientos(); // Recargar movimientos para el nuevo insumo
        }
    }

    public function anterior()
    {
        if ($this->indiceActual > 0) {
            $this->indiceActual--;
            $this->insumoId = $this->insumos[$this->indiceActual]->idInsumo;
            $this->cargarMovimientos(); // Recargar movimientos para el nuevo insumo
        }
    }

    // -------------------------------------------------------------------------
    // Propiedades Computadas para Navegación (Mantenemos como estaban)
    // -------------------------------------------------------------------------

    // Ojo: Cambié los nombres a camelCase para seguir convenciones
    public function getInsumoAnteriorProperty()
    {
        return $this->indiceActual > 0
            ? $this->insumos[$this->indiceActual - 1]
            : null;
    }

    public function getInsumoSiguienteProperty()
    {
        return $this->indiceActual < count($this->insumos) - 1
            ? $this->insumos[$this->indiceActual + 1]
            : null;
    }

    public function getInsumoProperty() // Devuelve el objeto Insumo actual
    {
        // Asegurarse que $indiceActual está dentro de los límites de $insumos
        return $this->insumos->get($this->indiceActual);
    }
    #endregion





    // -------------------------------------------------------------------------
    // Nuevos Métodos para Modales (Se implementarán en los siguientes pasos)
    // -------------------------------------------------------------------------
    #region Modal eliminacion
    /**
     * Funciones para funcionamiento de modal eliminación
     */

     public function confirmDelete($idMovimiento)
    {
        $this->movementIdToDelete = $idMovimiento;
        $this->showConfirmDeleteModal = true;
    }

    /**
     * Cierra el modal de confirmación sin borrar.
     */
    public function cancelDelete()
    {
        $this->movementIdToDelete = null;
        $this->showConfirmDeleteModal = false;
    }

    /**
     * Ejecuta la eliminación del movimiento seleccionado y cierra el modal.
     */
    public function deleteConfirmedMovement()
    {
        $movimiento = MovimientoAlmacen::find($this->movementIdToDelete);

        if ($movimiento) {
            // Aquí podríamos añadir lógica extra si es necesario antes de borrar
            // ej: verificar permisos, etc.

            $movimiento->delete();
            session()->flash('message', 'Movimiento eliminado correctamente.');

            // Recargar movimientos y recalcular stock (cuando implementemos el cálculo)
            $this->cargarMovimientos();
            // $this->recalculateStock($this->insumoId); // <-- Llamar cuando esté listo

        } else {
            session()->flash('error', 'Error: No se encontró el movimiento a eliminar.');
        }

        // Resetear y cerrar modal
        $this->movementIdToDelete = null;
        $this->showConfirmDeleteModal = false;
    }
    #endregion

     #region Modal Crear
    /**
     * Funciones para funcionamiento de modal eliminación
     */

    // Datos para el formulario de Entrada
    public $entradaData = [
        'fecha' => '',
        'cant_movida' => null, // Usaremos los nombres de columna BD
        'facturacion' => '',
        'observacion' => '',
        'lote' => '',
        'proveedor' => '',
        'tipoMovimiento' => 'entrada' // Fijo para esta pestaña
    ];


    /**
     * Abre el modal de creación, resetea formularios y establece pestaña por defecto.
     */
    public function openCreateModal()
    {
        $this->resetValidation(); // Limpia errores de validación previos
        $this->resetEntradaData(); // Resetea el form de entrada
        // $this->resetSalidaData(); // Resetearemos salidas después
        $this->createModalTab = 'salidas'; // Pestaña inicial
        $this->showCreateModal = true;
    }

    /**
     * Cierra el modal de creación.
     */
    public function closeCreateModal()
    {
        $this->showCreateModal = false;
    }

    /**
     * Resetea los datos del formulario de entrada a sus valores por defecto.
     */
    public function resetEntradaData()
    {
        $this->entradaData = [
            'fecha' => now()->format('Y-m-d'), // Fecha actual por defecto
            'cant_movida' => null,
            'facturacion' => '',
            'observacion' => '',
            'lote' => '',
            'proveedor' => '',
            'tipoMovimiento' => 'entrada'
        ];
    }

     /**
      * Cambia la pestaña activa en el modal de creación.
      */
    public function switchCreateTab($tab)
    {
        $this->createModalTab = $tab;
        $this->resetValidation(); // Limpiar errores al cambiar de pestaña
    }

    /**
     * Guarda un nuevo movimiento de ENTRADA.
     */
    public function saveEntrada()
    {
        // Validación (ejemplo básico, puedes refinarla)
        $validatedData = Validator::make($this->entradaData, [
            'fecha'         => 'required|date',
            'cant_movida'   => 'required|integer|min:1',
            'facturacion'   => 'nullable|string|max:100',
            'observacion'   => 'nullable|string|max:255',
            'lote'          => 'nullable|string|max:100',
            'proveedor'     => 'nullable|string|max:150',
        ])->validate(); // validate() lanza excepción si falla

        // Añadir el ID del insumo y asegurar el tipo de movimiento
        $validatedData['fk_insumos'] = $this->insumoId;
        $validatedData['tipo_movimiento'] = 'entrada'; // Asegurar tipo

        // Crear el movimiento
        MovimientoAlmacen::create($validatedData);

        session()->flash('message', 'Entrada registrada correctamente.');
        $this->closeCreateModal(); // Cerrar modal
        $this->cargarMovimientos(); // Recargar la tabla
        // $this->recalculateStock($this->insumoId); // Recalcular stock (cuando esté listo)
    }


    /**
     * 
     * 
     * 
     * parte de salidas
     * 
     * 
     * 
     * 
     * 
     */


      /**
     * Resetea el número de salidas y los datos del formulario de salidas.
     * Inicializa el array $salidasData con una fila por defecto.
     */
    public function resetSalidaData()
    {
        $this->salidasData = [];  // Limpiar array
        $this->salidasData[] = $this->getDefaultSalidaRow(); // Añadir la primera fila directamente
        $this->resetValidation();  // Añadir la primera fila
    }

    /**
     * Devuelve un array con los valores por defecto para una nueva fila de salida.
     */
    public function getDefaultSalidaRow()
    {
        return [
            'fecha' => now()->format('Y-m-d'),
            'cant_movida' => null,
            'lote' => '',
            'observacion' => '',
            'tipoMovimiento' => 'salida' // Establecer tipo
        ];
    }


    public function addSalidaRow()
    {
        // Opcional: Limitar el número máximo de filas que se pueden añadir
        // if (count($this->salidasData) >= 50) {
        //     session()->flash('error', 'No se pueden añadir más de 50 filas.');
        //     return;
        // }
        $this->salidasData[] = $this->getDefaultSalidaRow();
        $this->resetValidation(); // Limpiar errores al añadir fila
    }

    /**
     * Elimina una fila del formulario de salidas por su índice.
     * Asegura que siempre quede al menos una fila.
     */
    public function removeSalidaRow($index)
    {
        if (count($this->salidasData) > 1) { // Solo permite borrar si hay más de 1 fila
            unset($this->salidasData[$index]); // Elimina el elemento por índice
            $this->salidasData = array_values($this->salidasData); // Re-indexa el array para evitar huecos
            $this->resetValidation(); // Limpiar errores al quitar fila
        } else {
             // Opcional: Mostrar un mensaje indicando que no se puede borrar la última fila
             session()->flash('error', 'Debe haber al menos una fila de salida.');
        }
    }

    /**
      * Comprueba si el lote es requerido para el insumo actual.
      */
    public function checkLoteRequirement()
    {
        // Asegúrate de que $this->insumo está cargado (puede ser null si hay error)
        // y que tienes la propiedad 'control_cebado' en tu modelo Insumos.
        if ($this->insumo && $this->insumo->control_cebado === 'Y') {
             $this->loteIsRequired = true;
        } else {
             $this->loteIsRequired = false;
        }
         // Log::debug("Requisito de Lote para Insumo ID {$this->insumoId}: " . ($this->loteIsRequired ? 'Sí' : 'No'));
    }


    /**
     * Guarda los nuevos movimientos de SALIDA.
     * Valida cada fila individualmente.
     */
    public function saveSalidas()
    {
        $this->resetValidation();
        $errors = [];
        $validatedSalidas = []; // Array para guardar datos validados

        // Definir reglas base
        $baseRules = [
            'fecha'         => 'required|date',
            'cant_movida'   => 'required|integer|min:1',
            'observacion'   => 'nullable|string|max:255',
            // Añadimos la regla del lote condicionalmente
            'lote'          => $this->loteIsRequired
                                ? 'required|string|max:100'
                                : 'nullable|string|max:100',
        ];

        // Validar cada fila en $salidasData
        foreach ($this->salidasData as $index => $salida) {
            // Creamos un validador para esta fila específica
            $validator = Validator::make($salida, $baseRules);

            if ($validator->fails()) {
                // Si falla, guardamos los errores con un prefijo único por fila
                foreach ($validator->errors()->toArray() as $field => $message) {
                    // Usamos la key "salidasData.INDEX.campo" para que @error funcione
                    $errors["salidasData.{$index}.{$field}"] = $message[0]; // Tomamos solo el primer mensaje
                }
            } else {
                // Si pasa, guardamos los datos validados y añadimos info necesaria
                 $validated = $validator->validated();
                 $validated['fk_insumos'] = $this->insumoId;
                 $validated['tipo_movimiento'] = 'salida'; // Asegurar tipo
                 $validatedSalidas[] = $validated; // Añadir al array de datos listos para guardar
            }
        }

        // Si hubo CUALQUIER error en alguna fila, lanzamos la excepción
        if (!empty($errors)) {
            throw \Illuminate\Validation\ValidationException::withMessages($errors);
        }

        // Si llegamos aquí, todas las filas son válidas. Procedemos a guardar.
        try {
            foreach ($validatedSalidas as $dataToSave) {
                MovimientoAlmacen::create($dataToSave);
            }

            session()->flash('message', count($validatedSalidas) . ' salida(s) registrada(s) correctamente.');
            $this->closeCreateModal();
            $this->cargarMovimientos();
            // $this->recalculateStock($this->insumoId); // Recalcular stock (cuando esté listo)

        } catch (\Exception $e) {
            // Capturar cualquier error inesperado durante la creación
            Log::error("Error al guardar salidas: " . $e->getMessage());
            session()->flash('error', 'Ocurrió un error inesperado al guardar las salidas.');
            // Podríamos no cerrar el modal en caso de error de guardado
            // $this->closeCreateModal();
        }
    }



     #endregion




    #region otros



    public function eliminarMovimiento($idMovimiento) // <<< Lo mantendremos, pero lo llamaremos desde una confirmación
    {
        $movimiento = MovimientoAlmacen::find($idMovimiento);
        if ($movimiento) {
            $movimiento->delete();
            // Log::info("Movimiento {$idMovimiento} eliminado.");
            // Ya no necesitamos unset($this->movimientos[$idMovimiento]) porque recargaremos
             $this->cargarMovimientos(); // Recargar la lista después de eliminar
             // Aquí también deberíamos recalcular stock
             // $this->recalculateStock($this->insumoId); // (A implementar)
            session()->flash('message', 'Movimiento eliminado correctamente.'); // Mensaje de éxito opcional
        } else {
            // Log::warning("Intento de eliminar movimiento no existente: {$idMovimiento}");
            session()->flash('error', 'Error al eliminar el movimiento.'); // Mensaje de error opcional
        }
    }
    #endregion




}