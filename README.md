# Prerequisites

You need composer (>2) and php (>8.1)

# Installation

## Vendor installation :

```bash
composer install
```

## nodes_modules installation :

```bash
npm install
npm run build
```

# Configuration :

## Integrate .env file

```bash
cp .env.example .env
```

## Configure .env file

Configure the .env file to be able to connect to the database

Ex:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cofina_reporter
DB_USERNAME=cofina_reporter_user
DB_PASSWORD=root
```

## Application key generation

Generate laravel application key

```bash
php artisan key:generate
```

# Migrations and seed:

```bash
php artisan migrate --seed
```

# Lauch

```bash
php artisan serve
```

Your application is now available on http://localhost:8000
