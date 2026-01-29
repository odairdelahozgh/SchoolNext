# Resumen del Proyecto

SchoolNext es una aplicación web para la gestión escolar en Colombia, construida sobre el framework KumbiaPHP. Proporciona una solución integral para la gestión de diversos aspectos de una escuela, incluyendo estudiantes, padres, profesores, calificaciones y más.

## Tecnologías Clave

*   **Backend:** KumbiaPHP v1.2 (PHP 7.4+)
*   **Base de datos:** MySQL
*   **Frontend:** AdminLTE, HTMX, jQuery, JavaScript puro
*   **Gestión de Dependencias:** Composer para PHP

## Arquitectura

El proyecto sigue una arquitectura estándar Modelo-Vista-Controlador (MVC):

*   **Modelos:** Ubicados en `frontend/app/models`, representan la estructura de datos y la lógica de negocio de la aplicación.
*   **Vistas:** Ubicadas en `frontend/app/views`, se encargan de la capa de presentación, utilizando el motor de plantillas AdminLTE.
*   **Controladores:** Ubicados en `frontend/app/controllers`, gestionan la entrada del usuario, interactúan con los modelos y seleccionan la vista adecuada para renderizar.

La aplicación está estructurada con una clara separación de responsabilidades e incluye un sistema de control de acceso basado en roles (RBAC), con diferentes controladores para varios roles de usuario como administradores, coordinadores, profesores, padres y secretarias.

# Construcción y Ejecución

## Configuración del Backend

1.  **Servidor Web:** Configure un servidor web (por ejemplo, Apache, Nginx) con PHP 7.4 o superior.
2.  **Raíz del Documento:** Configure la raíz del documento del servidor web para que apunte al directorio `frontend/public`.
3.  **Base de Datos:**
    *   Cree una base de datos MySQL.
    *   Configure la conexión a la base de datos en `frontend/app/config/databases.php`. La configuración principal es `windsor`.
    *   **PENDIENTE:** Documentar el proceso para importar el esquema de la base de datos.
4.  **Dependencias:** Instale las dependencias de PHP usando Composer:

    ```bash
    composer install
    ```

## Configuración del Frontend

No se requiere ningún paso de construcción del frontend. Los assets del frontend se gestionan directamente en el directorio `frontend/public`.

# Convenciones de Desarrollo

## Estilo de Código

*   El proyecto utiliza PHP Mess Detector (`phpmd.xml`) y Code Climate (`codeclimate.yml`) para hacer cumplir la calidad del código.
*   Los nombres de los archivos están en español, mientras que parte del código está en inglés.

## Pruebas

*   El proyecto tiene un directorio de `tests`, pero no hay una documentación clara sobre cómo ejecutar las pruebas.
*   **PENDIENTE:** Documentar la estrategia de pruebas y cómo ejecutarlas.