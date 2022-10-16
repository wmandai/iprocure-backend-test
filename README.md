## About the REPO

1st Level interview task for the position of Backend Developer at iProcure with features:

- JWT Authentication.
- Hashed password.
- REST API endpoints for managing users, roles and products.
- User access restrictions.
- Customer access restrictions.
- Validations and Tests.
- PHP Code standards and formatting.

> Since Lumen will be discontinued in future because PHP has made significant improvement in performance and introduction of Larave Octane and Vapor, this application was developed using Laravel Framework.

## Installation

- ```git clone https://github.com/wmandai/iprocure-backend-test.git iprocure-backend```  

- Install composer dependencies ```composer install```

- Run database migrations ```php artisan migrate:fresh --seed``` and login using **admin@example.com** and password **admin**

- Run ```php artisan serve``` to start

## Running tests
- Run ```php artisan config:cache --env=testing```
- ```php artisan migrate:fresh --seed```
- ```vendor/bin/pest```
- To change back to local .env run ```php artisan config:cache --env=local```

## REST API Endpoints
- **POST** api/v1/auth/login - Login a user
- **POST**  api/v1/auth/logout - Logout user
- **POST**      api/v1/auth/refresh - refresh JWT Token
- **POST**      api/v1/auth/register - Register new user
- **DELETE**    api/v1/products/delete/{id} - Delete products
- **GET|HEAD**  api/v1/products/mine - Access my own products
- **POST**      api/v1/products/new - Create a new product
- **POST**      api/v1/products/search - Search product using price, name
- **GET|HEAD**  api/v1/products/show - Access product listings
- **PUT**       api/v1/products/update/{id} - Update a product
- **GET|HEAD**  api/v1/products/view/{id} - View product details
- **GET|HEAD**  api/v1/profile - View currently logged in user profile
- **DELETE**    api/v1/roles/delete/{id}  - Delete a role
- **POST**      api/v1/roles/new - Create a new role
- **GET|HEAD**  api/v1/roles/show - View roles listings
- **PUT**       api/v1/roles/update/{id} - Make changes to a role
- **GET|HEAD**  api/v1/roles/view/{id}  - View role details
- **DELETE**    api/v1/users/delete/{id} - Delete a user
- **POST**      api/v1/users/new - Create a new user
- **GET|HEAD**  api/v1/users/show - Show user listings
- **PUT**       api/v1/users/update/{id} - Make changes to user
- **GET|HEAD**  api/v1/users/view/{id}  - View user details

## Customer permissions
- Search products by name or price
- View products
- Create a new product
- View own products

## Security Vulnerabilities

If you discover a security vulnerability, please DM on twitter [@wmandai](https://twitter.com/wmandai). All security vulnerabilities will be promptly addressed.
