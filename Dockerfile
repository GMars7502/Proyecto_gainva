FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configuración PHP
COPY .docker/php/php.ini /usr/local/etc/php/conf.d/php.ini

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto completo
COPY . .

# Copiar ejemplo de env
COPY .env.example .env

# Instalar dependencias PHP
RUN composer install --no-interaction --optimize-autoloader

# Instalar dependencias JS y compilar assets
# RUN npm install && npm run build

# Generar key de Laravel
RUN php artisan key:generate

# Permisos para storage y cache
RUN chown -R www-data:www-data storage bootstrap/cache

CMD ["php-fpm"]
EXPOSE 9000
