<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


1. **Instalar dependencias:**
```
composer install
```

2. **Configurar el archivo de entorno:**
```
cp .env.example .env
```


3. **Generar la clave de la aplicación:**
```
php artisan key:generate
```

4. **Definir la api key de Openweather**
```
OPENWEATHERMAP_API_KEY={api_key}
```
5. **Iniciar servidor de desarrollo:**
```
php artisan serve
```
6. **Revisar el archivo en __routes/api__ para conocer las rutas y asi probar la api de OpenWeather por medio del navegador** 

7. **Para probar la api de OpenWeather por comandos, usar los mismos comandos suministrados en la prueba**



