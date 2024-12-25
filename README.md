# Laravel E-Commerce API

This is a simple e-commerce REST API built with Laravel. The API includes user authentication, product management, and order management functionalities. The application is structured to handle two types of users: customers and administrators.

## Features

- **User Authentication** (Register, Login)
- **Product Management** (Admin only)
- **Order Management** (Customers can place, view, edit, and delete their own orders; Admins can manage all orders)
- **Role-Based Access Control** (Admin and Customer roles)

## Installation & Setup

### Prerequisites

- PHP >= 8.0
- Composer
- MySQL or another supported database
- Laravel installed (`composer global require laravel/installer`)

### Step-by-Step Setup

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Abdulazeezvp/laravel-ecommerce-api.git
   cd laravel-ecommerce-api
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Create a `.env` file**:
   Copy the `.env.example` file to create a `.env` file:
   ```bash
   cp .env.example .env
   ```

4. **Configure environment variables**:
   Edit the `.env` file and update the database connection details:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```

5. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

6. **Run database migrations**:
   This will create the necessary tables in your database.
   ```bash
   php artisan migrate
   ```

7. **Run database seeders (optional)**:
   If you want to populate the database with some initial data, run the following command:
   ```bash
   php artisan db:seed
   ```

8. **Install Laravel Sanctum for API authentication**:
   Run the Sanctum migration:
   ```bash
   php artisan migrate --path=vendor/laravel/sanctum/database/migrations
   ```

9. **Serve the application**:
   Start the Laravel development server:
   ```bash
   php artisan serve
   ```

## API Endpoints

### Authentication

- **Register**:
  - `POST /register`
  - **Request Headers**:
    - `Accept: application/json`
  - **Request Body**:
    ```json
    {
      "name": "John Doe",
      "email": "john@example.com",
      "password": "secret",
      "password_confirmation": "secret"
    }
    ```

- **Login**:
  - `POST /login`
  - **Request Headers**:
    - `Accept: application/json`
  - **Request Body**:
    ```json
    {
      "email": "john@example.com",
      "password": "secret"
    }
    ```

### Product Listing

- **List Products**:
  - `POST /products/list`
  - **Request Headers**:
    - `Accept: application/json`

### Admin Routes (Authenticated Admin Only)

- **Create Admin Account**:
  - `POST /register-admin`
  - **Request Headers**:
    - `Accept: application/json`
  - **Request Body**:
    ```json
    {
      "name": "Admin Name",
      "email": "admin@example.com",
      "password": "secret",
      "password_confirmation": "secret"
    }
    ```

- **Manage Users**:
  - `GET, POST, PUT, DELETE /users`
  - **Request Headers**:
    - `Accept: application/json`

- **Manage Products**:
  - `GET, POST, PUT, DELETE /products`
  - **Request Headers**:
    - `Accept: application/json`

### Orders (Authenticated Users Only)

- **List Orders**:
  - `GET /orders`
  - **Request Headers**:
    - `Accept: application/json`

- **Create Order**:
  - `POST /orders`
  - **Request Headers**:
    - `Accept: application/json`
  - **Request Body**:
    ```json
    {
      "items": [
        { "product_id": 1, "quantity": 2 },
        { "product_id": 2, "quantity": 1 }
      ]
    }
    ```

- **Update Order**:
  - `PUT /orders/{id}`
  - **Request Headers**:
    - `Accept: application/json`

- **Delete Order**:
  - `DELETE /orders/{id}`
  - **Request Headers**:
    - `Accept: application/json`

## Middleware

- **Sanctum Authentication**:
  All routes within the authenticated section are protected by Laravel Sanctum, ensuring only authenticated users can access them.

- **Admin Middleware**:
  Admin routes are protected using custom middleware (`AdminMiddleware`). Only users with the role of admin can manage products and users.

## Testing the API with Postman

1. **Import the Postman collection**:
   Export your Postman collection as a JSON file and include it in the repository (or provide a link to the collection).

   Example: [Postman Collection Download Link](#)

2. **Use Postman**:
   After importing the collection, ensure that each request includes the appropriate **headers**:
   - `Accept: application/json`
   - **Authorization**: Bearer token (For authenticated routes)

3. **Authentication Token**:
   After logging in or registering, you will receive a token in the response. Use this token to authenticate your requests by setting it in the `Authorization` header as `Bearer {token}`.

## Running Tests

Run the application's test suite using PHPUnit:
```bash
php artisan test
```

## Additional Notes

- **API Responses**: All API responses are returned as JSON.
- **Authentication**: Uses Laravel Sanctum for token-based authentication.
- **Database**: Make sure your database is properly configured in the `.env` file.
