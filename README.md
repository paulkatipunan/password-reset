# Password Reset

Laravel password reset.

```
Give examples
```

### Installing

Install package using Composer:

```
composer require paulkatipunan/password_reset
```

Register the package's service provider in config/app.php:

```
'providers' => [

        PaulKatipunan\ServiceProvider::class,
        
    ],
```

Run the Artisan's command:

```
php artisan vendor:publish --provider="PaulKatipunan\ServiceProvider" --tag="email-template"

```
This will publish the email template of the password reset link. And you can modify it if you want.


Run this Artisan's command: if you want to publish the change password blade file.

```
php artisan vendor:publish --provider="PaulKatipunan\ServiceProvider" --tag="change-password-blade-file"

```
If you publish the change password blade file. you will be redirect to the change password blade file after clicking the sent link in your email and if you did not publish the blade file this will return you an object that you need to reset your password.

Example:
```
{
  "email": "your_email@gmail.com",
  "token": "MWBtYVqpkotOehmVwPgCSXn3iKgYsdcIWJF7HyLQQESwWgA9pBx3Kw1isMhT",
  "created_at": "2018-11-22 06:09:59"
}

```



