# TechSolutions - JWT Auth

Aplicación web con autenticación JWT desarrollada con Laravel.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)
![JWT](https://img.shields.io/badge/JWT-Auth-green.svg)

## Características

-   Autenticación JWT con cookies HttpOnly
-   Registro y login con validación
-   Dashboard protegido con middleware
-   API REST funcional
-   Renovación automática de tokens

## Tecnologías

-   Laravel 12.x
-   PHP 8.2+
-   MySQL
-   JWT (tymon/jwt-auth)
-   Vite

## Instalación

```bash
# Clonar e instalar
git clone https://github.com/bastianCeronDuque/techsolutions.git
cd techsolutions
composer install
npm install

# Configurar
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

# Base de datos
php artisan migrate

# Compilar y ejecutar
npm run build
php artisan serve
```

## Uso

1. **Registro**: Ve a `/registro` y crea una cuenta
2. **Login**: Accede en `/login` con tus credenciales
3. **Dashboard**: Accede automáticamente tras login exitoso

## API Endpoints

```http
POST /api/register - Registro de usuario
POST /api/login    - Inicio de sesión
GET  /api/me       - Perfil del usuario (requiere auth)
POST /api/logout   - Cerrar sesión
```

## Estructura

```
app/
├── Http/Controllers/
│   ├── AuthController.php     # Autenticación
│   └── DashboardController.php
├── Middleware/
│   └── JwtMiddleware.php      # Middleware JWT
└── Models/User.php

resources/
├── js/landing/                # JavaScript
├── css/landing/               # Estilos
└── views/                     # Vistas Blade

routes/
├── web.php                    # Rutas web
└── api.php                    # API REST
```

## Seguridad

-   Cookies HttpOnly (protección XSS)
-   Contraseñas hasheadas con bcrypt
-   Validación robusta de datos
-   Protección CSRF
-   Tokens con múltiples fuentes

## Autor

**Bastián Cerón Duque**  
GitHub: [@bastianCeronDuque](https://github.com/bastianCeronDuque)
**Felipe Morales Roa**  
GitHub: [@felipeDev303](https://github.com/felipeDev303)
