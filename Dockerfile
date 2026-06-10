FROM php:8.3-cli

# Install dependencies sistem
RUN apt-get update && apt-get install -y libzip-dev zip unzip nodejs npm

# Install ekstensi PHP untuk MySQL
RUN docker-php-ext-install pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set direktori kerja
WORKDIR /app
COPY . .

# Install dependency Laravel & Build Frontend
RUN composer install --optimize-autoloader --no-dev
RUN npm install && npm run build

# Jalankan migrasi database dan server Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
