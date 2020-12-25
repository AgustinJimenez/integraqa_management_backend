# INSTALL DEPENDENCIES

```
    composer install
```

# GENERATE ENVIROMENT VARIABLES FILE

```
    cp .env.example .env
```

# GENERATE KEY

```
    php artisan key:generate
```

# CREATE DATABASE STRUCTURE

```
    php artisan migrate
```

# POPULATE DATABASE

```
    php artisan db:seed
```

# USED IMPLEMENTATIONS

-   [Laravel Fortify](https://laravel.com/docs/8.x/fortify)
-   [Laravel Sanctum](https://laravel.com/docs/8.x/sanctum)

# OTHER PACKAGES INSTALLED

-   [LARAVEL-ROLES](https://github.com/jeremykenedy/laravel-roles)
-   [FAKER](https://fakerphp.github.io)
