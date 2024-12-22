# Gunakan image PHP dengan Apache
FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy semua file Laravel ke dalam container
COPY . /var/www/html

# Set direktori kerja
WORKDIR /var/www/html

# Set permission untuk folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install dependensi Laravel
RUN composer install --no-dev --optimize-autoloader

# Jalankan Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=3000"]

EXPOSE 3000
