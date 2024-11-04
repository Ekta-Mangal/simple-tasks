# Developer Screening Process & Laravel Assessment

This application is designed to evaluate your Laravel expertise, coding style, adherence to SOLID principles, and ability to write unit tests.

What we are looking for includes:

-   Development using best practices
-   Usage of the latest Laravel version
-   Unit testing with PEST

## Tips
For validation rules, try Form Request Validation

https://laravel.com/docs/11.x/validation#form-request-validation

For json response, please use Eloquent API Resources

https://laravel.com/docs/11.x/eloquent-resources#generating-resources

For tesing, please use Pest

https://laravel.com/docs/11.x/testing#creating-tests

https://pestphp.com/docs/writing-tests

For more laravel training, please visit laracasts.com

https://laracasts.com/series

There are free tutorials available. There are lots of tutorials available on YouTube as well.

## Overview

You will be tasked with developing a REST API. No frontend work is required; you can test the API using tools like Postman. We recommend committing your Postman collection when submitting the completed application.

## Routes

To view all the routes in the API, run the following command:

```
php artisan route:list
```

If you are running the application in localhost, the url will be

```
http://localhost:8000/
http://localhost:8000/api/users/register
http://localhost:8000/api/users/login
http://localhost:8000/api/users/logout
http://localhost:8000/api/tasks

```

## Database & migrations

We have added the database and migrations for this application and sqlite database is used.

```
php artisan migrate
php artisan db:seed
```

Following database tables will be created specifically for this application.

-   users - users are stored in this table.
-   user_contacts - user's contacts are stored in this table.
-   tasks - tasks for the users

(For more details, please check the database and migrations files.)

# Developer Tasks

## Part 1: API Implementation

### 1. User Controller

-   Implement the logic for user register, login and logout.
-   Implement the logic to delete a user.

Register payload may look like:

```
{
    "email": "test@test.com",
    "name": "Jack",
    "password": "12345678",
    "contact": {
        "phone": "1234567890",
        "mobile": "1234567890",
        "address1": "address1",
        "address2": "address2",
        "address3": "address3",
        "postcode": "postcode",
        "country_id": "GB" // code or id
    }
}
```

### 3. Task Controller

-   Add middleware for authentication to manage task operations.
-   Implement full CRUD functionality for tasks.
-   Implement the task listing (GET /api/tasks). The response should return the following JSON structure:

```
{
  "data": [
    {
      "id": 2,
      "title": "Task 1",
      "user": {
        "name": "Name of the user",
        "email": "user@example.com"
         "country": {
          "name": "United Kingdom"
        }
      },
      "description": "Task 1 description",
      "task_date": "2024-10-08T09:33:29.000000Z",
      "completed_at": "2024-10-08T09:33:29.000000Z",
      "created_at": "2024-10-08T09:33:29.000000Z",
      "updated_at": "2024-10-08T09:33:29.000000Z"
    }
  ],
  ...
}
```

## Part 2: Unit Testing

-   Write unit tests for the code you implement.
-   Ensure your code coverage is above 90% by running:

```
php artisan test
php artisan test --profile --coverage --min=90
```

If any code was not written by you and needs to be skipped, please add @codeCoverageIgnore to the method.

```
/**
* store
* @codeCoverageIgnore
*/
public function store(array $data): void
{
    //This is not needed for this screening test
    return;
}
```

## Part 3: Submitting

Please submit the completed application to your GitHub repository and send us the link.

## Getting Started

Download the latest source

```
git clone https://github.com/kurianvarkey/simple-tasks.git simple-tasks
```

## Running the application

Go to simple-tasks dir

```
cd simple-tasks
```

If PHP is installed on your machine, you can run the application.

```
composer update

php artisan migrate

php artisan serve
```

## Other ways to run the application

If docker is installed on your machine, you can run the application.

```
docker run --rm -v $(pwd):/app composer install

docker-compose up -d

docker-compose exec api php artisan migrate
```

### Composer update

```
docker run --rm -v $(pwd):/app composer update
```

### Artisan about

```
docker-compose exec api php artisan about
```

### Run the migration

```
docker-compose exec api php artisan migrate
```

### Run the test

```
docker-compose exec api php artisan test --coverage
```

### Application url

http://localhost:8000/

### Run the database seeding first if requesting from postman

```
docker-compose exec api php artisan db:seed
```

## Docker Troubleshooting

In case docker is showing any issues or errors, please try following:

After downloading/cloning the project, run the following command:

```
$ cd appointhq-dev-app
$ docker run --rm -v $(pwd):/app composer install
$ sudo chown -R dev:dev .
```

## Install PHP 8.3

```
https://php.watch/articles/php-8.3-install-upgrade-on-debian-ubuntu#php83-debian-quick
```

## Install Composer

```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
```

## Artisan commands

Clear Application Cache

```
php artisan cache:clear
```

Clear Route Cache

```
php artisan route:clear
```

Clear Configuration Cache

```
php artisan config:clear
```
