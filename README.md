## Test Repo 🚧 🚧 🚧

## Installation

You can install the package via composer:

```bash
composer require wpzag/laravel-notifications
```

You can publish the translations with:

```bash
php artisan vendor:publish --tag="laravel-notifications-translations"
```

This will publish the translations to app/resources/lang folder.

## Usage

1) First we need to use the Notifiable trait in the user model:

```php
    use Wpzag\LaravelNotifications\Traits\Notifiable;
    class User extends Authenticatable
    {
        use Notifiable;
     }
```

2) Then we need to create a notification class that extends BaseNotification class:

```php
 <?php
	
	namespace Wpzag\LaravelNotifications\Tests\TestNotifications;
	
	use Wpzag\LaravelNotifications\BaseNotification;
	
	class TestNotification extends BaseNotification
	{
		public function getTranslationParams() : array
		{
			return [
				'user'=>'user.name',
			];
		}
		
		
		public function getNotificationLink() : string
		{
			return 'users/'.$this->relations['user']['id'];
		}
	}

```

3) Notify the user

```php
   User::first()->notify(
         TestNotification::create(
                 key: 'user_updated',
                 relations: ['user' => User::first()],
                 data: ['random' => 'data']
    ));
```

4) Add entry in translation file:

```php
return [
  'user_updated' => ':user has updated his profile',
  'titles' => [ 'user_updated' => 'User Updated' ],
]
```

4) Then we get the notifications with:

```php
  use Wpzag\LaravelNotifications\LaravelNotifications;
  LaravelNotifications::getPaginatedNotifications();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/wpzag/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [wpzag](https://github.com/wpzag)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
