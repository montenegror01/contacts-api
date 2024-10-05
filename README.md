
# Proyecto Laravel

Este proyecto es una API de contactos que utiliza un **backend** desarrollado en **Laravel**. La aplicación permite agregar, editar, eliminar y listar contactos, junto con sus teléfonos, correos electrónicos y direcciones.



## Requisitos del sistema

- PHP >= 8.0
- Composer
- MySQL u otra base de datos soportada

## Instalación

1. Clonar el repositorio:

```bash
git clone https://github.com/montenegror01/contacts-api.git
cd contacts-api
```

2. Instalar dependencias PHP:

```bash
composer install
```

3. Configurar el archivo `.env`:

```bash
cp .env.example .env
php artisan key:generate
```

4. Configura los detalles de la base de datos en el archivo `.env`.

En estas lineas de codigo
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

5. Migrar la base de datos y crear datos ficticios:

```bash
php artisan migrate
php artisan db:seed --class=ContactoSeeder
```

6. (Opcional) Si tienes assets frontend, ejecuta:

```bash
npm install && npm run dev
```

7. Iniciar el servidor local:

```bash
php artisan serve
```


Asegúrate de configurar correctamente la base de datos de pruebas en el archivo `.env.example`.
