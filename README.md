# Potosí Imperial Stay

Sistema web de gestión de hospedajes vacacionales en la ciudad de Potosí, Bolivia.

**Eslogan:** *"Descubre la historia, disfruta la experiencia."*

## Requisitos
- PHP 8.3+
- Composer
- Node.js 20+
- PostgreSQL 14+

## Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/floressalvadorerasmo15-sketch/ProyectoFinal.git
cd ProyectoFinal
```

2. Instalar dependencias:
```bash
composer install
cp .env.example .env
php artisan key:generate
```

3. Configurar `.env` con PostgreSQL:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=potosi_imperial_stay
DB_USERNAME=postgres
DB_PASSWORD=tu_password
```

4. Migrar y sembrar datos:
```bash
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

## Credenciales de prueba

| Rol | Email | Contraseña |
|---|---|---|
| Administrador | admin@potosi.test | Admin2026$ |
| Propietario | propietario@potosi.test | Prop2026$ |
| Recepcionista | recepcionista@potosi.test | Recep2026$ |
| Cliente | cliente@potosi.test | Clien2026$ |

## Roles y Permisos

| Rol | Permisos |
|---|---|
| Administrador | Todo el sistema + gestionar usuarios |
| Propietario | Crear/editar/eliminar sus hospedajes y habitaciones, confirmar reservas |
| Recepcionista | Ver hospedajes, confirmar y editar reservas |
| Cliente | Ver hospedajes, crear/cancelar reservas, comentar |

## Stack Tecnológico
- Laravel 13 + PHP 8.3
- PostgreSQL
- Laravel Breeze (Blade)
- spatie/laravel-permission v8
- Tailwind CSS

## Fases de desarrollo
- **v0.1** — Modelo de datos (migraciones, modelos, factories, seeders)
- **v0.2** — Autenticación con Breeze + campo de rol en registro
- **v0.3** — RBAC completo (Policies, roles/permisos, navbar por rol)
- **v0.4** — CRUD completo (Hospedajes, Habitaciones, Reservas, Comentarios)
- **v1.0** — Calidad y UX (filtros, paginación, errores 403, README)

## Autor
Erasmo Flores Salvador — INF560 Desarrollo Web Backend — UATF 2026