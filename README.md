# CRUD Operations Best Practices Example for Beginners

[![Tests](https://github.com/mr-punyapal/basic-crud/actions/workflows/tests.yml/badge.svg)](https://github.com/mr-punyapal/basic-crud/actions/workflows/tests.yml)

## Getting Started 🚀

These instructions will guide you through setting up the project on your local machine for development and testing.

### Prerequisites

You need to have installed the following software:

- PHP 8.2
- Composer 2.0.8
- MySQL 8.0.23
- Node 20.10.0

### Installing

Follow these steps to set up a development environment:

1. **Clone the repository**

    ```bash
    git clone https://github.com/mr-punyapal/basic-crud.git
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

    ```bash
    npm install
    ```

3. **Duplicate the .env.example file and rename it to .env**

    ```bash
    cp .env.example .env
    ```

4. **Generate the application key**

    ```bash
    php artisan key:generate
    ```

5. **Run migration and seed**

    ```bash
    php artisan migrate --seed
    ```

6. **Run the application**

    ```bash
    npm run dev
    ```

    ```bash
    php artisan serve
    ```

### Installing with Sail

Laravel Sail is helpful when your local environment doesn't match with project requirements like different PHP versions.
Only requirement is Docker to work with this project. For more details on Laravel Sail click [here](https://laravel.com/docs/10.x/sail).

Follow these steps to set up a development environment using Laravel Sail:

1. **Clone the repository**

    ```bash
    git clone https://github.com/mr-punyapal/basic-crud.git
    ```

2. **Install dependencies**

    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs
    ```

    ```bash
    ./vendor/bin/sail run --rm npm install
    ```

3. **Duplicate the .env.example file and rename it to .env**

    ```bash
    cp .env.example .env
    ```

4. **Generate the application key**

    ```bash
    sail artisan key:generate
    ```

5. **Run migration and seed**

    ```bash
    sail artisan migrate --seed
    ```

6. **Run the application**

    ```bash
    sail up -d
    ```

    ```bash
    sail npm run dev
    ```

## How to Test the Application 🧪

- Copy .env.testing.example to .env.testing
- Update the database configuration according to your local environment
- Create a new database for testing
- Run the following commands

    ```bash
    php artisan key:generate --env=testing
    ```

    ```bash
    npm install && npm run build
    ```

    ```bash
    ./vendor/bin/pest --parallel
    ```

### Give Feedback 💬

Give your feedback on [@MrPunyapal](https://x.com/MrPunyapal)

### Contribute 🤝

Contribute if you have any ideas to improve this project.
