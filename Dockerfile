FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=node:20 /usr/local /usr/local

WORKDIR /app

# Copiar TODO el proyecto primero
COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Instalar dependencias Node
RUN npm ci

# Compilar Vite
RUN npm run build

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --host=0.0.0.0 --port=${PORT:-8080}