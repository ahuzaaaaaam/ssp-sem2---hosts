# Pizza Shop - Laravel 12 eCommerce Application

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Pizza Shop

Pizza Shop is a modern eCommerce application built with Laravel 12, featuring a responsive UI designed with Tailwind CSS. This application allows users to browse pizza products, customize their own pizzas, add items to cart, and place orders.

### Key Features

- User authentication and registration
- Product browsing with category filtering
- Shopping cart functionality
- Custom pizza builder
- Checkout and order placement
- Admin dashboard for product management
- RESTful API with Laravel Sanctum authentication

## Installation and Setup

### Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL or MariaDB
- XAMPP or similar local development environment

### Installation Steps

1. Clone the repository to your local machine:
   ```
   git clone https://github.com/yourusername/pizza-shop.git
   ```

2. Navigate to the project directory:
   ```
   cd pizza-shop
   ```

3. Install dependencies:
   ```
   composer install
   ```

4. Create a copy of the `.env.example` file and rename it to `.env`:
   ```
   cp .env.example .env
   ```

5. Generate an application key:
   ```
   php artisan key:generate
   ```

6. Configure your database connection in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pizza_shop
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Run the database migrations and seed the database:
   ```
   php artisan migrate --seed
   ```

8. Start the development server:
   ```
   php artisan serve
   ```

9. Visit `http://localhost:8000` in your browser to access the application.

## API Documentation

The application provides a RESTful API for accessing product data. API documentation is available at `/api/docs` when running the application.

### Authentication

The API uses Laravel Sanctum for authentication. To access protected endpoints, you need to obtain an API token by sending a POST request to the `/api/tokens` endpoint.

### Available Endpoints

- `GET /api/products` - Get all products
- `GET /api/products/{id}` - Get a specific product
- `POST /api/products` - Create a new product (admin only)
- `PUT /api/products/{id}` - Update a product (admin only)
- `DELETE /api/products/{id}` - Delete a product (admin only)

For detailed information about request and response formats, please refer to the API documentation page.

## Project Structure

- **app/Models** - Contains Eloquent models for User, Product, and Cart
- **app/Http/Controllers** - Contains controllers for handling requests
- **app/Http/Middleware** - Contains middleware for authentication and authorization
- **database/migrations** - Contains database migrations
- **resources/views** - Contains Blade templates for the views
- **routes** - Contains route definitions for web and API

## Testing

To run the tests, use the following command:
```
php artisan test
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
