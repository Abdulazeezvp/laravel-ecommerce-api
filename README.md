# Laravel E-Commerce API

This is a simple e-commerce REST API built with Laravel. The API includes user authentication, product management, and order management functionalities. The application is structured to handle two types of users: customers and administrators.

## Features

- **User Authentication** (Register, Login)
- **Product Management** (Admin only)
- **Order Management** (Customers can place, view, edit, and delete their own orders; Admins can manage all orders)
- **Role-Based Access Control** (Admin and Customer roles)

## Installation & Setup

### Prerequisites

- PHP >= 8.2
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
    will seed default admin user(username: admin@email.com,password:123456)
    
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
### Product Show

- **Show Product details**:
  - `POST /product/{id}`
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

## Products

### List Products

- **URL**: `/products/list`
- **Method**: `POST`
- **Headers**:
  - `Accept: application/json`

- **Response** (Success):
  ```json
  [
    {
      "id": 1,
      "name": "Product A",
      "price": 50.00,
      "description": "Sample product A description",
      "created_at": "2023-12-24T10:00:00.000000Z",
      "updated_at": "2023-12-24T10:00:00.000000Z"
    },
    {
      "id": 2,
      "name": "Product B",
      "price": 75.00,
      "description": "Sample product B description",
      "created_at": "2023-12-24T10:00:00.000000Z",
      "updated_at": "2023-12-24T10:00:00.000000Z"
    }
  ]
  ```

---

### Create Product

- **URL**: `/products`
- **Method**: `POST`
- **Headers**:
  - `Accept: application/json`
  - `Authorization: Bearer {token}` (for authenticated admins)

- **Request Body**:
  ```json
  {
    "name": "New Product",
    "price": 100.00,
    "description": "A brief description of the new product"
  }
  ```

- **Response** (Success):
  ```json
  {
    "id": 3,
    "name": "New Product",
    "price": 100.00,
    "description": "A brief description of the new product",
    "created_at": "2023-12-24T10:15:00.000000Z",
    "updated_at": "2023-12-24T10:15:00.000000Z"
  }
  ```

- **Response** (Unauthorized):
  ```json
  {
    "message": "Unauthorized"
  }
  ```

---

### Show Product

- **URL**: `/products/{id}`
- **Method**: `GET`
- **Headers**:
  - `Accept: application/json`

- **Response** (Success):
  ```json
  {
    "id": 1,
    "name": "Product A",
    "price": 50.00,
    "description": "Sample product A description",
    "created_at": "2023-12-24T10:00:00.000000Z",
    "updated_at": "2023-12-24T10:00:00.000000Z"
  }
  ```

- **Response** (Product not found):
  ```json
  {
    "message": "Product not found"
  }
  ```

---

### Update Product

- **URL**: `/products/{id}`
- **Method**: `PUT`
- **Headers**:
  - `Accept: application/json`
  - `Authorization: Bearer {token}` (for authenticated admins)

- **Request Body**:
  ```json
  {
    "name": "Updated Product",
    "price": 120.00,
    "description": "Updated description"
  }
  ```

- **Response** (Success):
  ```json
  {
    "id": 1,
    "name": "Updated Product",
    "price": 120.00,
    "description": "Updated description",
    "created_at": "2023-12-24T10:00:00.000000Z",
    "updated_at": "2023-12-24T10:30:00.000000Z"
  }
  ```

---

### Delete Product

- **URL**: `/products/{id}`
- **Method**: `DELETE`
- **Headers**:
  - `Accept: application/json`
  - `Authorization: Bearer {token}` (for authenticated admins)

- **Response** (Success):
  ```json
  {
    "message": "Product deleted"
  }
  ```

- **Response** (Product not found):
  ```json
  {
    "message": "Product not found"
  }
  ```



## Orders

### List Orders

- **URL**: `/orders`
- **Method**: `GET`
- **Headers**:
  - `Accept: application/json`
  - `Authorization: Bearer {token}` (for authenticated users)

- **Response** (Admin):
  ```json
  [
    {
      "id": 1,
      "user_id": 2,
      "total_price": 150.00,
      "status": "pending",
      "items": [
        {
          "id": 1,
          "order_id": 1,
          "product_id": 1,
          "quantity": 2,
          "price": 50.00,
          "product": {
            "id": 1,
            "name": "Product A",
            "price": 50.00
          }
        }
      ]
    }
  ]
  ```

- **Response** (Non-admin, only their own orders):
  ```json
  [
    {
      "id": 1,
      "user_id": 2,
      "total_price": 150.00,
      "status": "pending",
      "items": [
        {
          "id": 1,
          "order_id": 1,
          "product_id": 1,
          "quantity": 2,
          "price": 50.00,
          "product": {
            "id": 1,
            "name": "Product A",
            "price": 50.00
          }
        }
      ]
    }
  ]
  ```

---

### Show Order

- **URL**: `/orders/{id}`
- **Method**: `GET`
- **Headers**:
  - `Accept: application/json`
  - `Authorization: Bearer {token}` (for authenticated users)

- **Response** (Success):
  ```json
  {
    "id": 1,
    "user_id": 2,
    "total_price": 150.00,
    "status": "pending",
    "items": [
      {
        "id": 1,
        "order_id": 1,
        "product_id": 1,
        "quantity": 2,
        "price": 50.00,
        "product": {
          "id": 1,
          "name": "Product A",
          "price": 50.00
        }
      }
    ]
  }
  ```

- **Response** (Order not found):
  ```json
  {
    "message": "Order not found"
  }
  ```

- **Response** (Unauthorized to view another user's order):
  ```json
  {
    "message": "Unauthorized"
  }
  ```

---

### Create Order

- **URL**: `/orders`
- **Method**: `POST`
- **Headers**:
  - `Accept: application/json`
  - `Authorization: Bearer {token}` (for authenticated users)

- **Request Body**:
  ```json
  {
    "items": [
      { "product_id": 1, "quantity": 2 },
      { "product_id": 2, "quantity": 1 }
    ]
  }
  ```

- **Response** (Success):
  ```json
  {
    "id": 1,
    "user_id": 2,
    "total_price": 150.00,
    "items": [
      {
        "id": 1,
        "order_id": 1,
        "product_id": 1,
        "quantity": 2,
        "price": 50.00,
        "product": {
          "id": 1,
          "name": "Product A",
          "price": 50.00
        }
      },
      {
        "id": 2,
        "order_id": 1,
        "product_id": 2,
        "quantity": 1,
        "price": 50.00,
        "product": {
          "id": 2,
          "name": "Product B",
          "price": 50.00
        }
      }
    ]
  }
  ```

- **Response** (Unauthorized):
  ```json
  {
    "message": "Unauthorized"
  }
  ```

---

### Update Order

- **URL**: `/orders/{id}`
- **Method**: `PUT`
- **Headers**:
  - `Accept: application/json`
  - `Authorization: Bearer {token}` (for authenticated users)

- **Request Body** (Admin):
  ```json
  {
    "status": "shipped"
  }
  ```

- **Response** (Success):
  ```json
  {
    "id": 1,
    "user_id": 2,
    "total_price": 150.00,
    "status": "shipped"
  }
  ```

- **Response** (Unauthorized):
  ```json
  {
    "message": "Unauthorized"
  }
  ```

- **Response** (Order not found):
  ```json
  {
    "message": "Order not found"
  }
  ```

---

### Delete Order

- **URL**: `/orders/{id}`
- **Method**: `DELETE`
- **Headers**:
  - `Accept: application/json`
  - `Authorization: Bearer {token}` (for authenticated users)

- **Response** (Success):
  ```json
  {
    "message": "Order deleted"
  }
  ```

- **Response** (Unauthorized):
  ```json
  {
    "message": "Unauthorized"
  }
  ```

- **Response** (Order not found):
  ```json
  {
    "message": "Order not found"
  }
  ```

## Middleware

- **Sanctum Authentication**:
  All routes within the authenticated section are protected by Laravel Sanctum, ensuring only authenticated users can access them.

- **Admin Middleware**:
  Admin routes are protected using custom middleware (`AdminMiddleware`). Only users with the role of admin can manage products and users.


## Additional Notes

- **API Responses**: All API responses are returned as JSON.
- **Authentication**: Uses Laravel Sanctum for token-based authentication.
- **Database**: Make sure your database is properly configured in the `.env` file.
