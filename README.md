# Laravel Backend

### Installation


Clone this repository and install its dependencies with `composer install` . 
# Install dependencies...
composer install

Then, copy the `.env.example` file to `.env` and supply the URL of your database and mail configuration:

```
# DB configuration...

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crm_db
DB_USERNAME=root
DB_PASSWORD=
```
# Mail configuration...
Don't forget to instruct your application to use the database driver by updating the QUEUE_CONNECTION variable in your application's .env file

QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=**host**
MAIL_PORT=587
MAIL_USERNAME=***your email***
MAIL_PASSWORD=**your password**
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

Finally, run the application via `php artisan serve`. The application will be available at `http://localhost:8000` and php `artisan queue:work`  :

```
# run the  server...
npm run dev
# Send Email by queue...
artisan queue:work
```
