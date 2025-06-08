# Laravel Position Management

## Requirements:

PHP >= 8.1 (Installed seperately)

Composer

Mysql (Using Xampp)

Git (Installed seperately)


## Installation

1. Clone Repository

git clone  https://github.com/username/repo name.git

cd repo name

composer install

cp. .env.example .env

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=your_database_name

DB_USERNAME=root

DB_PASSWORD=  # leave blank if using XAMPP default

php artisan key:generate

php artisan:migrate

php artisan:serve

Now visit it


## Testing with Postman

1. Open postman
2. Import
3. Select positions_postman_collection.json in /Postman file/positions_postman_collection.json
4. New Collection and click Runner
