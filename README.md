# Getting Started with CRM  Php Laravel APP

This project was created with PHP Laravel

## Projet Setup
Clone the repository from master branch

RUN

## `cd blog`
moves inside the project directory

### `composer install`
Installs necessary packages using composer

### `cp .env.example .env`
Copies example env file into your env file\
Create a database and add credentials to your database using your own credentials as shown in below example\
DB_CONNECTION=mysql\
DB_HOST=127.0.0.1\
DB_PORT=3306\
DB_DATABASE=blog\
DB_USERNAME=root\
DB_PASSWORD=

### `php artisan key:generate`
generates application key

### `php artisan migrate`
Runs the migration in your local database

### `php artisan serve`
Starts the laravel server at http://localhost:8000\

### `php artisan test`
Runs the unit test cases

### `Import the public/Blog.postman_collection.json to postman `
Imports the postman collection of blog APIs.

### `Enjoy the application`
