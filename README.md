
# Project: Order Tracking System (Laravel + Sanctum + Swagger)

## Project Description
This project is designed to track orders using Laravel. It utilizes **Sanctum** for session-based authentication and **Swagger** for API documentation.

The project includes several key components:

- **Laravel**: Used as the primary backend framework.
- **Sanctum**: Provides session-based or API token authentication.
- **Swagger**: Used for documenting the API and integrated with Swagger UI for testing.
- **Laradock**: Used for local deployment.

## Installation

### Steps to run the project locally:

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/order-tracking-system.git
   cd order-tracking-system
   ```

2. **Install dependencies**
   Use Composer to install PHP dependencies and npm to install JavaScript dependencies:
   ```bash
   composer install
   npm install
   ```

3. **Configure the `.env` file**
   Copy the `.env.example` file to `.env` and configure it according to your environment:
   ```bash
   cp .env.example .env
   ```

   Make sure to configure the following:
    - **DB_CONNECTION**: Database connection parameters.
    - **SANCTUM_STATEFUL_DOMAINS**: Required for proper Laravel Sanctum functionality.
    - **APP_URL**: Project URL for local use.

4. **Run Laradock**
   Go to the Laradock directory and start the containers:
   ```bash
   cd laradock
   docker-compose up -d nginx postgres redis
   ```

5. **Run migrations**
   Run database migrations:
   ```bash
   php artisan migrate
   ```

6. **Generate the application key**
   Generate the application key:
   ```bash
   php artisan key:generate
   ```

## Sanctum Authentication

The project uses **Laravel Sanctum** for session-based authentication or token-based API access.

### Sanctum Setup:
1. Add the following settings to your `.env` file:
   ```env
   SANCTUM_STATEFUL_DOMAINS=yourdomain.com
   L5_SWAGGER_GENERATE_ALWAYS=true
   ```

2. Use `security={{"sanctum":{}}}` in Swagger to document endpoints that use cookie-based authentication through Sanctum.

## API Documentation with Swagger

1. **Swagger UI** is integrated into the project to view API documentation.
```
yourdomain.com/api/documentation#/
```

## Testing
The project includes unit and feature tests that can be executed with the following command:
```bash
php artisan test
```

## Additional Information

- The project uses **PostgreSQL** as the database.
- **Redis** is used for queues and caching.
- API documentation is automatically generated via Swagger.

