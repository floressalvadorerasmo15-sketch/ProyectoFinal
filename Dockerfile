FROM php:8.4-cli

# Directorio de trabajo
WORKDIR /app

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libpq-dev \
    libzip-dev \
    npm \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar todo el proyecto
COPY . .

# Permitir Composer como root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependencias PHP
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts \
    --no-interaction

# Instalar dependencias de Node
RUN npm install

# Compilar Vite
RUN npm run build

# Exponer el puerto de Railway
EXPOSE 8080

# Iniciar Laravel
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}