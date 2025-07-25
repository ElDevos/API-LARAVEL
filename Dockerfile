# Usa PHP 8.2 con FPM
FROM php:8.2-fpm

# Instala extensiones del sistema necesarias
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip mbstring exif pcntl bcmath gd

# Instala Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia todos los archivos del proyecto Laravel
COPY . .

# Instala dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Da permisos adecuados a los directorios necesarios
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

# Expone el puerto del servidor embebido
EXPOSE 8000

# Comando de inicio: usa el servidor Laravel integrado
CMD php artisan serve --host=0.0.0.0 --port=8000
