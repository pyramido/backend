# Pyramido API

```
composer install
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your DB configs, then

```
php artisan migrate
php artisan db:seed
```
