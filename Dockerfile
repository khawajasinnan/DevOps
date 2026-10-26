# ---------- Stage 1: frontend assets (Vite) ----------
FROM node:22-alpine AS assets
WORKDIR /build
COPY package*.json .npmrc* ./
RUN npm install
COPY . .
RUN (npm run build || echo "Vite build skipped") && mkdir -p public/build

# ---------- Stage 2: application tier (PHP-FPM + Laravel) ----------
FROM php:8.3-fpm AS app
WORKDIR /var/www

RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip libzip-dev \
    && docker-php-ext-install pdo_mysql zip bcmath pcntl \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-scripts --no-autoloader

COPY . .
COPY --from=assets /build/public/build ./public/build

RUN composer dump-autoload --optimize \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]

# ---------- Stage 3: presentation tier (Nginx) ----------
FROM nginx:1.27-alpine AS web
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=app /var/www/public /var/www/public
EXPOSE 80
