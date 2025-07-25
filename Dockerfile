FROM php:8.2-fpm

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece directorio de trabajo
WORKDIR /var/www

# Copia todos los archivos
COPY . .

# Instala dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Da permisos
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Expone puerto
EXPOSE 8000

# Comando de arranque: usa el servidor Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
