FROM php:8.4-fpm

WORKDIR /app

# 1. Install system dependencies & Node.js (v20)
RUN apt-get update && apt-get install -y \
    libpq-dev unzip git curl \
    && docker-php-ext-install pdo pdo_pgsql \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 2. Copy Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Copy application files
COPY . .

# 4. Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# 5. Build Vite frontend assets
RUN npm ci && npm run build

CMD php artisan config:clear && php artisan view:clear && php -S 0.0.0.0:10000 -t public