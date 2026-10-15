
```
# Stage 1: Build Frontend Assets (Vite + Tailwind)
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY ["platform literasi digital/package*.json", "./"]
RUN npm install
COPY ["platform literasi digital/", "./"]
RUN npm run build

# Stage 2: Run Backend (Laravel PHP)
FROM php:8.3-cli-alpine
WORKDIR /var/www/html

RUN apk add --no-cache \
    sqlite \
    sqlite-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install pdo pdo_sqlite zip bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY ["platform literasi digital/", "./"]
COPY --from=node-builder /app/public/build/ ./public/build/

RUN cp .env.example .env && \
    composer install --no-dev --optimize-autoloader && \
    touch database/database.sqlite && \
    php artisan key:generate --force && \
    php artisan migrate --force && \
    (php artisan db:seed --force || true) && \
    chown -R www-data:www-data storage bootstrap/cache database

EXPOSE 80

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
```