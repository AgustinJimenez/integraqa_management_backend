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

# SERVE

```
    php artisan serve --host 0.0.0.0
```

# SERVE WITH YARN

```
    yarn start
```

# USED IMPLEMENTATIONS

-   [Laravel Fortify](https://laravel.com/docs/8.x/fortify)
-   [Laravel Sanctum](https://laravel.com/docs/8.x/sanctum)

# OTHER PACKAGES INSTALLED

-   [LARAVEL-ROLES](https://github.com/jeremykenedy/laravel-roles)
-   [FAKER](https://fakerphp.github.io)
