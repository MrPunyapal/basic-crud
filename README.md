# Example of crud operations best practices for beginner
[![Tests](https://github.com/mr-punyapal/basic-crud/actions/workflows/tests.yml/badge.svg)](https://github.com/mr-punyapal/basic-crud/actions/workflows/tests.yml)
## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

You need to have installed the following software:

```
php 8.2

composer 2.0.8

mysql 8.0.23
```

### Installing

A step by step series of examples that tell you how to get a development env running

Clone the repository

```bash

git clone https://github.com/mr-punyapal/basic-crud.git

```

Install dependencies

```bash

composer install

```

duplicate the .env.example file and rename it to .env

```bash

cp .env.example .env

```

Generate the application key

```bash

php artisan key:generate

```

migration and seed

```bash

php artisan migrate --seed

```

Run the application

```bash

php artisan serve

```

## How to test the application

- copy .env.testing.example to .env.testing

- change the database configuration as per your local environment

- create a new database for testing

- run the following command


```bash
php artisan key:generate --env=testing
```
```bash
./vendor/bin/pest --parallel
```

### give me feedback on  [@MrPunyapal](https://x.com/MrPunyapal)

### contribute if have any idea to improve this project




