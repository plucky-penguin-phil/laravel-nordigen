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
