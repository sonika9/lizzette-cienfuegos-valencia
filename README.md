## Requerimientos

- PHP 8.3+
- Apache
- MySQL
- Redis

## Instalación

### Descargar proyecto

- cd /var/www
- git clone https://github.com/sonika9/lizzette-cienfuegos-valencia.git

### Instalación de dependencias
- composer install

### Instalación y compilación de assets 
- npm install
- npm run dev

### Configuración de Base de datos
- Crear base de datos en MySQL.
- Agregar variables de configuracion en el archivo .env

- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=
- DB_USERNAME=
- DB_PASSWORD=

### Ejecutar las migraciones
- cd /var/www/proyecto_nombre
- php artisan migrate

### Ejecutar seeders
- DatabaseSeeder - Contiene la creación del usuario para el Admin Panel
- php artisan db:seed --class=DatabaseSeeder
- ProductoSeeder - Agrega 2 productos de prueba
- php artisan db:seed --class=ProductoSeeder

### Permisos en directorios
- cd /var/www/proyecto_nombre
- sudo chmod -R 775 storage bootstrap/cache
- sudo chmod -R 775 storage/framework/views

### Redis
Agregar variables de configuracion en el archivo .env

- CACHE_STORE=redis
- CACHE_PREFIX=appdata_cache
- REDIS_CLIENT=phpredis
- REDIS_HOST=127.0.0.1
- REDIS_PASSWORD=null
- REDIS_PORT=6379

### Configuración de VirtualHost
Agregar VirtualHost en Apache:
```
<VirtualHost *:80>
ServerName tienda.test
DocumentRoot /var/www/proyecto_ecommerce/public

    <Directory /var/www/proyecto_ecommerce>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/tienda_error.log
    CustomLog ${APACHE_LOG_DIR}/tienda_access.log combined
</VirtualHost>
```
Habilitar VirtualHost
- sudo a2ensite tienda.conf

Asegurarse de tener habilidado mod_rewrite en Apache
- sudo a2enmod rewrite

Recargar configuración de Apache
- sudo systemctl reload apache2

Agregar a /etc/hosts
- 127.0.0.1 tienda.test

### Probar el acceso a la aplicación
- Sección pública -> http://tienda.test/
- Acceso Admin panel -> http://tienda.test/login   usuario: test@test.com   contraseña: 12345678
- Sección Gráficas -> http://tienda.test/dashboard
- Sección Productos -> http://tienda.test/productos
- Sección Pedidos -> http://tienda.test/pedidos
