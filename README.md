# Prueba Técnica - Is Eazy

Este proyecto es una prueba técnica que implementa un sistema de gestión de tiendas y productos.

Se ha desarrollado usando **Laravel** y se ha dockerizado para simplificar la instalación y ejecución.

## Tecnologías utilizadas

- PHP 8 / Laravel 12
- MySQL
- Docker & Docker Compose
- PHPUnit (tests automatizados)

## Instrucciones para levantar el proyecto

1. Levantar los contenedores de Docker:

```bash
docker compose up -d --build
```
2. Instalar dependencias

```bash
docker compose run app composer install
```

3. Configurar variables de entorno

```bash
cp .env.example .env
```

4. Generar clave de aplicación

```bash
docker compose exec app php artisan key:generate
```

5. Correr migraciones y seeders

```bash
docker compose exec app php artisan migrate --seed
```

## Correr tests
```bash
docker compose exec app php artisan test
```

## Acceder a la documentación de la API
```bash
localhost:7071/docs/documentation
```
