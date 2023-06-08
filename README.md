# Laravel 8 con L5 swagger openapi 

## Introducción
Ejemplo en laravel 8, utilizando mysql, además de autentificación vía sanctum para el consumo de apis.

## Instalación
Para instalar esto, debes seguir las siguientes indicaciones
- composer install
- cp .env.example .env
- php artisan key:generate
- php artisan migrate

# Ejemplos de uso
Para ver los ejemplos de uso, puedes hacer lo siguiente:
- Ir a la ruta /api/documentation
- Si quieres autenticarte o consumir apis que necesiten autentificación: 
- - email: user@user.com
- - password: user
- En el botón authorization, ingresa el token de la siguiente forma: Bearer (token devuelto del login)
- Dentro de app->Http->Providers->RouteServiceProcider.php en la función configureRateLimiting, se configura el límite de solicitudes y el mensaje.

# Referencias
- https://github.com/DarkaOnLine/L5-Swagger

# Instrucciones
Para el uso de swagger se realizó lo siguiente:
- composer require "darkaonline/l5-swagger"
- php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider" 
- php artisan l5-swagger:generate (puede que de error al no estar comentada las apis)
- en el .env:
- - L5_SWAGGER_GENERATE_ALWAYS=true #si queremos que se genere automáticamente sin necesidad de estar escribiendo el comando anterior
- en config/l5-swagger.php:
- - verificar que sanctum y todo su contenido no esté comentado dentro de la variable 'securitySchemes'
- en resources/views/vendo/l5-swagger/index.blade.php:
- - eliminé 'layout: "StandaloneLayout",' que sirve como buscador de documentos json para mostrar.

## Bitácora

Fecha | Descripcion | Acciones
| :-- | :-: | :-:
04-005-2023 11:11 | instalación de proyecto | Ejecutar _composer install_ y _php artisan migrate
