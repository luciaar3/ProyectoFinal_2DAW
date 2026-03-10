# Market Manager

Aplicación web para la gestión de comercios estáticos y ambulantes, y su relación con los clientes.

Este proyecto está desarrollado como trabajo final del Grado Superior de Desarrollo de Aplicaciones Web (DAW). La aplicación permitirá organizar la actividad de los comercios del mercado (fijos y ambulantes), facilitando la gestión de catálogos, rutas, reservas de productos y la interacción con los clientes.

## Tecnologías utilizadas

- **Frontend:** HTML5, CSS3, JavaScript (Vanilla JS / Fetch API) y Bootstrap.
- **Backend:** Laravel (PHP).
- **Base de datos:** MySQL.

## Estructura del proyecto

El proyecto sigue una arquitectura monolítica basada en el patrón MVC (Modelo-Vista-Controlador) proporcionado por Laravel:
- `/app` → Lógica de negocio (Modelos y Controladores PHP).
- `/resources/views` → Vistas del frontend (Archivos Blade con HTML).
- `/resources/js` y `/public/js` → Scripts de JavaScript para peticiones asíncronas y mapas.
- `/database` → Migraciones y Seeders de la base de datos MySQL.

## Funcionalidades previstas

- **Gestión de Usuarios:** Registro y login con 3 roles distintos (Administrador, Comerciante, Cliente).
- **Panel del Cliente:** Búsqueda de comercios, mapa de ubicaciones, reservas/pedidos abonando fianza, favoritos y foro.
- **Panel del Comerciante:** Gestión de perfil, catálogo de productos, control de stock y calendario de rutas (para ambulantes).
- **Panel de Administración:** Validación de nuevos comerciantes, moderación de foros/denuncias y estadísticas globales.

## Equipo

- Lucía Andreu Ribelles
- Marcos Bárcenas Parras
- Karla Juan Castelló

## Instalación del proyecto

Para levantar el proyecto en tu entorno local, clona el repositorio y ejecuta los siguientes comandos en la carpeta raíz:

```bash
# 1. Instalar dependencias de PHP
composer install

# 2. Configurar variables de entorno
cp .env.example .env

# 3. Generar la clave de la aplicación
php artisan key:generate

# 4. Instalar dependencias de Frontend (Vite/Mix)
npm install

# 5. Ejecutar las migraciones para crear las tablas en MySQL
php artisan migrate

# 6. Levantar el servidor local
php artisan serve
```

## GitHub
```bash

# 1. Antes de empezar a trabajar, me bajo lo último que hayan hecho mis compañeros
git checkout main
git pull origin main

# 2. Creo una rama nueva para mi tarea (ejemplo: hacer el buscador)
git checkout -b feature/buscador-cliente

* La palabra "feature" en inglés significa literalmente "característica" o "funcionalidad".

Cuando en Git escribimos el comando git checkout -b feature/buscador-cliente, lo que estamos haciendo es ponerle una "etiqueta" o "carpeta" al nombre de nuestra rama para tener el trabajo organizado. El guion o la barra diagonal (/) le dice a Git y a plataformas como GitHub cómo agrupar las ramas. *

# ... (Aquí programan, guardan, prueban) ...

# 3. Subo mi rama a GitHub
git add .
git commit -m "Añadido buscador por categorías"
git push origin feature/buscador-cliente
