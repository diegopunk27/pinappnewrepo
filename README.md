# Ejecutar en desarrollo

1. Clonar el repositorio
2. Ejcutar 
```
  composer install
```
3. Copiar el archivo .env.example y renombrar como .env
```
  cp .env.example .env
```
4. Crear la estructura de la base de datos
```
  php artisan migrate
```
5. Si lo deseas, poblar la base de datos con información ficticia 
```
  php artisan db:seed
```
6. Correr la api en un puerto, por ejemplo 8000
```
  php -S localhost:8000 -t ./public
```
