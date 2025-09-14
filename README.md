# Proyecto Pagina_Gainva_v1

Este proyecto es una aplicación Laravel que utiliza Docker para su entorno de desarrollo.

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalado lo siguiente:

*   **Docker Desktop:** Incluye Docker Engine y Docker Compose.
    *   [Descargar Docker Desktop](https://www.docker.com/products/docker-desktop)
*   **(Opcional pero recomendado en Windows) WSL 2:** Asegúrate de que Docker Desktop esté configurado para usar el backend de WSL 2 para un mejor rendimiento de los volúmenes.

## Configuración del Entorno

1.  **Clonar el repositorio:**
    ```bash
    git clone [URL_DE_TU_REPOSITORIO]
    cd pagina_gainva
    ```

2.  **Configurar el archivo `.env`:**
    Copia el archivo de ejemplo `.env.example` a `.env` si aún no lo tienes:
    ```bash
    cp .env.example .env
    ```
    Abre el archivo `.env` y asegúrate de que las variables de conexión a la base de datos coincidan con las configuraciones de Docker:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=laravel
    DB_PASSWORD=secret
    ```
    También, si no tienes una `APP_KEY` generada, Docker la generará automáticamente durante la construcción, pero puedes añadirla manualmente si ya la tienes:
    ```ini
    APP_KEY=base64:TuAppKeyGenerada
    ```

3.  **Configuración de PHP (opcional, si necesitas ajustes específicos):**
    El archivo `.docker/php/php.init` contiene configuraciones PHP. Si necesitas realizar ajustes adicionales (por ejemplo, límites de memoria, tiempo de ejecución, etc.), edita este archivo. Ya incluye configuraciones comunes para desarrollo.

## Ejecutar el Proyecto

1.  **Asegúrate de que Docker Desktop esté en ejecución.**

2.  **Detener y Limpiar (recomendado si tuviste problemas anteriores o quieres un inicio limpio):**
    Si previamente habías levantado los contenedores y deseas una limpieza completa, incluyendo los volúmenes de datos de MySQL (lo que borrará la base de datos):
    ```bash
    docker-compose -f Docker-compose.yml down -v
    ```
    *Esto eliminará el volumen `dbdata` y la base de datos asociada. Úsalo con precaución.*

3.  **Construir y Levantar los Contenedores:**
    Desde la raíz del proyecto, ejecuta el siguiente comando:
    ```bash
    docker-compose -f Docker-compose.yml up --build -d
    ```
    *   `docker-compose -f Docker-compose.yml`: Especifica el archivo de configuración de Docker Compose.
    *   `up`: Crea y levanta los servicios definidos.
    *   `--build`: Fuerza la reconstrucción de las imágenes de los servicios (importante para aplicar cambios en `Dockerfile` o `php.init`).
    *   `-d`: Ejecuta los contenedores en segundo plano.

4.  **Ejecutar Migraciones y Seeders (después de levantar los contenedores):**
    Una vez que los contenedores estén corriendo, puedes ejecutar las migraciones de la base de datos y los seeders para poblar datos:
    ```bash
    docker-compose -f Docker-compose.yml exec app php artisan migrate --seed
    ```

5.  **Acceder a la Aplicación:**
    Tu aplicación Laravel debería estar accesible en tu navegador en:
    [http://localhost:8080](http://localhost:8080)

## Comandos Útiles de Docker Compose

*   **Ver el estado de los servicios:**
    ```bash
    docker-compose -f Docker-compose.yml ps
    ```
*   **Ver los logs de un servicio (ej. `app`):**
    ```bash
    docker-compose -f Docker-compose.yml logs -f app
    ```
*   **Ejecutar un comando dentro de un servicio (ej. `app`):**
    ```bash
    docker-compose -f Docker-compose.yml exec app bash
    ```
    (Esto te dará una terminal dentro del contenedor `app`).
*   **Detener los servicios:**
    ```bash
    docker-compose -f Docker-compose.yml stop
    ```
*   **Detener y eliminar los servicios (manteniendo los volúmenes de datos):**
    ```bash
    docker-compose -f Docker-compose.yml down
    ```
