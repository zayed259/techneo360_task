<h1 align="center">Techneo360 Task</h1>

----------

# Getting started

## Installation

Clone the repository

    git clone https://github.com/zayed259/techneo360_task.git

Switch to the repository folder

    cd techneo360_task

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    copy .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

To seed the database with dummy data

    php artisan db:seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

Admin login information

    Email: admin@gmail.com
    Password: admin123

Employee login information

    Email: zayed@gmail.com
    Password: 12345678
    
**TL;DR command list**

    git clone https://github.com/zayed259/techneo360_task.git
    cd techneo360_task
    composer install
    cp .env.example .env
    php artisan key:generate
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan db:seed
    php artisan serve

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers` - Contains all the controllers
- `app/Http/Middleware` - Contains the middleware
- `config` - Contains all the application configuration files
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the web routes defined in web.php file
- `resources` - Contains all the view blade file
- `public` - Contains all the assets file, storage link folder

## Query or Information

If you have any query or information details email me on [zayedbd24@gmail.com](mailto:zayedbd24@gmail.com). Thank you

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
