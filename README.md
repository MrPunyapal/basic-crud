# CRUD Operations Best Practices Example for Beginners

[![Tests](https://github.com/mr-punyapal/basic-crud/actions/workflows/tests.yml/badge.svg)](https://github.com/mr-punyapal/basic-crud/actions/workflows/tests.yml)

## Getting Started 🚀

These instructions will guide you through setting up the project on your local machine for development and testing.

### Prerequisites

You need to have installed the following software:

- PHP 8.2
- Composer 2.0.8
- MySQL 8.0.23

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

## How to Test the Application 🧪

- Copy .env.testing.example to .env.testing
- Update the database configuration according to your local environment
- Create a new database for testing
- Run the following commands

    ```bash
    php artisan key:generate --env=testing
    ```

    ```bash
    ./vendor/bin/pest --parallel
    ```

### Give Feedback 💬

Give your feedback on [@MrPunyapal](https://x.com/MrPunyapal)

### Contribute 🤝

Contribute if you have any ideas to improve this project.
