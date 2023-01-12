<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## ¿Como correr el proyecto?

Use docker para crear una pequeña aplicacion laravel y que no interfiera con las versiones de nuestro local, basta con posicionarnos dentro del proyecto y ejecutar *docker-compose -f docker-compose-localhost.yml up -d --build* luego podremos visitar en nuestro navegador la url http://localhost/api/zip-codes/76000

## ¿Como resolvi el problema?

Primero analizando que era mas facil leer si un txt, xml o xlsx, me incline por el txt despues de leer linea por linea y ver que no tomaba demasiado tiempo ademas de la facilidad para buscar por los | separadores

- Descargar txt con codigos postales.
- Moverlos dentro de la carpeta storage para despues leerlo.
- Obtener el contenido del txt.
- Separar el contenido por \n, como sabemos toda linea de un archivo termina con un \n.
- Iterar cada row y separar por |.
- Como el txt esta estandarizado se sabe que la posicion 0 es el codigo postal entonces basta con hacer un if para evaluar.
- Ir guardando los datos en variables.
- Retornar respuesta.


## Features adicionales

Como todos los codigos postales estan ordenados y pueden repetirse n veces entonces si buscamos un codigo postal que esta en la linea 1 y en la 2 identifico cuando ya vamos en la linea 3 y como ya es un codigo postal diferente termino el flujo dejando asi de iterar 150 mil filas que serian innecesarias.