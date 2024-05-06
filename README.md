#Wappify

## Description

This package helps to receive WhatsApp Cloud API messages in Laravel projects.

## Installation

To install this package, simply run:

```bash
composer require ailuracode/wappify
```

After installing the package, Laravel will auto-load it. You also need to add the service provider in your `config/app.php` file:

```php
'providers' => [
     // Another suppliers...
     AiluraCode\Wappify\WappifyServiceProvider::class,
],
```

## Use

To start using this package in your Laravel project, you only need to run the work queue using the following command:

```bash
php artisan wappify:queue
```

## License

This package is released under the MIT License. For more details, please refer to the [LICENSE](LICENSE) file.

## Credits

- Developed by [SiddharthaGF](https://github.com/SiddharthaGF) for AiluraCode.
- Use the library [netflie/whatsapp-cloud-api](https://github.com/netflie/whatsapp-cloud-api).
- Use GuzzleHttp to make HTTP requests.
- Use [spatie/laravel-medialibrary](https://github.com/spatie/laravel-medialibrary) for multimedia file management.
- Use PHPUnit for unit testing.

## Project status

This package is under active development and is continually being improved. It is recommended to stay tuned for future updates for new features and improvements.