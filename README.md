# laravel-nordigen
This package provides a wrapper around the Nordigen PHP library for interacting with the Nordigen open banking API. For details on how to use the API and the PHP library,
please visit this repo - [nordigen/nordigen-php](https://github.com/nordigen/nordigen-php)

# Installation
```
composer require pluckypenguin/laravel-nordigen
```

# Configuration
This wrapper allows for easy customisation by adding the following config options to your .env file:

* `NORDIGEN_SECRET_ID` - Your Nordigen app secret ID
* `NORDIGEN_SECRET_KEY` - Your Nordigen app secret key
* `NORDIGEN_USE_SANDBOX` - Should we use the Nordigen sandbox provider, or live providers?
* `NORDIGEN_DEFAULT_COUNTRY` - The default country code to be used when none is provided. Mostly used for interacting with institutions.

You can choose to publish the Nordigen configuration file provided by this package by running `php artisan vendor:publish PluckyPenguin\LaravelNordigen\LaravelNordigenServiceProvider`

# Usage
Dependency injection is supported with this package for easily accessing the NordigenClient class:
```php
class MyNordigenController extends Controller {
    public function handleNordigenCallback(NordigenClient $nordigenClient) {
        // your code here...
    }
}
```

Alternatively, you can use the Facade provided by this package:
```php
use PluckyPenguin\LaravelNordigen\Facades\NordigenClient;
$accounts = NordigenClient::accounts->get();
```

Lastly, you can initialize your own instance of the NordigenClient class, with the settings from your .ENV using:
```php
$nordigenClient = app()->make(\Nordigen\NordigenPHP\API\NordigenClient::class);
```

# Middleware
Included in this package, is a middleware you can utilise to ensure users who are signed into your application, always have an active Nordigen API session.
To include this on your route, use the `auth.nordigen` middleware.

# User Trait
To help you get the most out of the package, there is a user trait called `HasNordigenApiToken` which provides easy access to the access and  refresh tokens.
In order to use the trait provided with this package, you will need to run the migrations - `php artisan migrate`.
This will add 4 new columns to your `users` table - `nordigen_access_token`, `nordigen_access_expires`, `nordigen_refresh_token` and `nordigen_refresh_expires`.
