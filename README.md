Project name - User Financials
This project is based for managing User's(internal and external(API)) financial transactions allowing the user to manipulate data according to its roles.

1. Getting Started
 - Composer install
 - Copy .env.example for .env using
  - cp .env.example .env
  - change database creds as required.
 - Generate key for the Laravel Application
  - php artisan key:generate
 - run the migrations for default users and roles to create necessary table structures.
   - php artisan migrate
 - seeding the the default users and roles to get the things started.
   - php artisan db:seed
    - A default user with basic(user) role.
    - A default admin with admin role.
 - Run the node module package for using Laravel's in-built authentication.
   - Used Node version 19.0. 
   - npm install and npm run dev
 - Generate Passport Keys and Personal Access clients
  - php artisan passport:keys
  - php artisan passport:install

2. About
 - Users with basic(user) role will be able to view their own transactions.
 - Users with basic(user) role will be able to create their own transactions.
 - Users with basic(user) role will be able to update their own transactions.
 - Users with basic(admin) role will be able to view transactions for all users.
 - Users with basic(admin) role will be able to create transactions for all users.
 - Users with basic(admin) role will be able to update transactions for all users.
 - Users with basic(admin) role will be able to delete transactions for all users.
 - Only user with basic(user) role will be able to register using internal Register functionality and APi. As per now, only 1 admin has been added via seeder and only that user will be able to manipulate data for all users.
 - Managed Error loggings using laravel stack logging for any errors.

3. API Usage
 - For viewing the transactions, the user will first need to generate token for API authorization by login or register API.
  - {path}/api/login
  - {path}/api/register
 - After generating the token, the user should use that genarated token for accessing the APIs for managing and viewing transactions. User should pass the token as a Bearer Token in headers.
  - For viewing transactions
    - {path}/api/financials
  - For creating transactions  
    - {path}/api/financials/create
  - For updating transactions
    - {path}/api/financials/update
  - For deleting transactions
    - {path}/api/financials/delete

4. Security
 - All Request data has been validated using Laravel in-built Validator.
 - All Request data has been sanitized using middlewares for trimming, covert html characters for preventing SQL injection and cross-site scripting (XSS).
 - Implemented authenticated user Token(Bearer token) based API authorization.
 - Implemented for request rate limiting upto 20 requests per minute per user. 
