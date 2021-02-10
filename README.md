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

# GENERATE JWT TOKEN

```
php artisan jwt:secret
```

# SERVE

```
    php artisan serve --host 0.0.0.0
```

# SERVE WITH YARN

```
    yarn start
```

### USE [MAILHOG](https://github.com/mailhog/MailHog)

### [MAILHOG WEB](http://localhost:8025)

### START MAILHOG (FROM COMMAND LINE)

```
mailhog
```
