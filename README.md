# Sistema de Pruebas en PHP

Este proyecto implementa un repositorio de pruebas con PHP 7.4 y MySQL. Permite gestionar asignaturas, pruebas y preguntas con cuatro alternativas. Las pruebas son públicas y la administración queda restringida al usuario *admin*.

## Requisitos
- PHP >=7.4
- MySQL
- Composer

## Instalación
1. Clonar el repositorio y ejecutar `composer install`.
2. Crear una base de datos y usuario en MySQL y ajustar las credenciales en `config.php`.
3. Importar el archivo `sql/db.sql` para crear las tablas y el usuario administrador.
4. Servir el directorio `public` desde un servidor web (Apache, Nginx, etc.).

## Funcionalidades
- Listado público de pruebas con DataTables.
- Visualización de preguntas con alternativas.
- Panel de administración con SweetAlert y Toastr para feedback.
- Importación de pruebas desde archivos Excel (requiere PHPSpreadsheet).

## Estructura
- `public/`: páginas visibles por cualquier usuario (listado, login, ver prueba).
- `admin/`: páginas de administración (dashboard, CRUD de asignaturas, pruebas y preguntas, importación desde Excel).
- `sql/db.sql`: esquema de base de datos.
- `config.php`: conexión a la base de datos.

Para ingresar al panel de administración utilice el usuario `admin` con la contraseña definida en `sql/db.sql`.
