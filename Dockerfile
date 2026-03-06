# ---- Node build (Vite) ----
FROM node:20-alpine AS nodebuild
WORKDIR /app

# package.json は src/ 配下にある前提（Laravel標準）
COPY src/package.json src/package-lock.json* ./
RUN npm ci

COPY src/ ./
RUN npm run build


# ---- PHP deps (Composer) ----
FROM composer:2 AS composerbuild
WORKDIR /app
COPY src/composer.json src/composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

COPY src/ ./
# artisanや最適化系は起動時にやる（ENVが必要なため）


# ---- Runtime (nginx + php-fpm) ----
FROM php:8.3-fpm-alpine

# System packages
RUN apk add --no-cache \
    nginx \
    supervisor \
    bash \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    postgresql-dev \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    intl \
    mbstring \
    zip \
    opcache

# Nginx config
COPY docker/nginx/render.conf /etc/nginx/http.d/default.conf

# Supervisor config
COPY docker/supervisord.conf /etc/supervisord.conf

# App files
WORKDIR /var/www/html
COPY --from=composerbuild /app /var/www/html
COPY --from=nodebuild /app/public/build /var/www/html/public/build

# Permissions (storage, cache)
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Start script
COPY scripts/render-start.sh /usr/local/bin/render-start.sh
RUN chmod +x /usr/local/bin/render-start.sh

EXPOSE 80

CMD ["/usr/local/bin/render-start.sh"]