# Laravel Containers Package

## Install

Add package & repository to composer.json

```json
{
    "require": {
        "maximzhurkin/containers": "dev-master"
    },
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/maximzhurkin/containers.git"
        }
    ]
}
```

Install Containers with [composer](https://getcomposer.org/doc/00-intro.md):

```shell
composer update maximzhurkin/containers
```

Publish vendor config

```shell
php artisan vendor:publish --provider="Maximzhurkin\Containers\Providers\ContainerServiceProvider"
```

Add providers in bootstrap/providers.php:

```php
use Maximzhurkin\Containers\Providers\ContainerServiceProvider;
use Maximzhurkin\Containers\Providers\RouteServiceProvider;

return [
    AppServiceProvider::class,
    ContainerServiceProvider::class,
    RouteServiceProvider::class,
];
```

## Use

Create Container

```shell
php artisan app:container Order
# This will create files in containers/Order folder
```

Add created provider to bootstrap/providers.php configuration file

```php
use Containers\Order\Providers\OrderProvider;

return [
    //...
    OrderProvider::class,
];
```

Add created routing class to config/containers.php configuration file

```php
use Containers\Order\Http\Routing\OrderRouting;

return [
    'routes' => [
        OrderRouting::class,
    ],
    'rate_limiting' => [
        'enabled' => false,
        'for' => 'api',
        'per_minute' => 60,
    ],
];
```

### Other commands

Create container to exist container

```shell
php artisan app:container OrderStatus Order
```

Create controller

```shell
php artisan app:controller User
# containers/User/Http/Controllers/UserController.php
```

Create factory

```shell
php artisan app:factory User
# containers/User/Data/Factories/UserFactory.php
```

Create migration

```shell
php artisan app:migration User
# containers/User/Data/Migrations/202406141352_create_users_table.php
```

Create model

```shell
php artisan app:model User
# containers/User/Models/User.php
```

Create provider

```shell
php artisan app:provider User
# containers/User/Providers/UserProvider.php
```

Create repository

```shell
php artisan app:repository User
# containers/User/Data/Repositories/UserRepository.php
```

Create request

```shell
php artisan app:request User
# containers/User/Http/Requests/UserRequest.php
```

Create routing

```shell
php artisan app:routing User
# containers/User/Http/Routing/UserRouting.php
```
