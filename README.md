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


### Configuration
Laravel's mailer has to be configured. Fill out these values in the .env file:
```
        MAIL_DRIVER=<DRIVER>            # e.g. smtp
        MAIL_HOST=<HOST>                # e.g. smtp.gmail.com
        MAIL_PORT=<PORT>                # e.g. 587
        MAIL_USERNAME=<USERNAME>        # e.g. your_email@gmail.com
        MAIL_PASSWORD=<PASSWORD>        # e.g. youemailpassword
        MAIL_ENCRYPTION=<ENCRYPTION>    # e.g. ssl
        MAIL_FROM_EMAIL=<EMAIL>         # e.g. from_mail@gmail.com
        MAIL_SUBJECT=<SUBJECT>          # Reset password
 ```

If you using gmail, also you need to enable less secure apps 
```
        https://myaccount.google.com/u/1/lesssecureapps
```

### Usage
In your controller just the sendPasswordResetLink() helper, you need to pass the email.
```
  public function create(Request $request)
  {
    
    return sendPasswordResetLink(request('email'));

  }
```
