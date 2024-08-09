# Laravel Containers Package

A package with commands for a convenient Laravel project structure

```text
containers
├── Order
│   ├── Data
│   │   ├── Factories
│   │   │   ├── OrderFactory.php
│   │   │   └── OrderStatusFactory.php
│   │   ├── Migrations
│   │   │   ├── 202406141234_create_orders_table.php
│   │   │   └── 202406141350_create_order_statuses_table.php
│   │   └── Repositories
│   │       ├── OrderRepository.php
│   │       └── OrderStatusRepository.php
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── OrderController.php
│   │   │   └── OrderStatusController.php
│   │   ├── Requests
│   │   │   ├── StoreOrderRequest.php
│   │   │   ├── StoreOrderStatusRequest.php
│   │   │   ├── UpdateOrderRequest.php
│   │   │   └── UpdateOrderStatusRequest.php
│   │   └── Routing
│   │       ├── OrderRouting.php
│   │       └── OrderStatusRouting.php
│   ├── Models
│   │   ├── Order.php
│   │   └── OrderStatus.php
│   └── Providers
│       ├── OrderProvider.php
│       └── OrderStatusProvider.php
└── User
    ├── Data
    │   ├── Factories
    │   │   └── UserFactory.php
    │   ├── Migrations
    │   │   └── 2024_06_14_134255_create_users_table.php
    │   └── Repositories
    │       └── UserRepository.php
    ├── Http
    │   ├── Controllers
    │   │   └── UserController.php
    │   ├── Requests
    │   │   ├── StoreUserRequest.php
    │   │   ├── UpdateUserRequest.php
    │   │   └── UserRequest.php
    │   └── Routing
    │       └── UserRouting.php
    ├── Models
    │   └── User.php
    └── Providers
        └── UserProvider.php
```

## Install

### Add package & repository to composer.json

```json
{
    "require": {
        "maximzhurkin/containers": "dev-master"
    },
    "autoload": {
        "psr-4": {
            "Containers\\": "containers/"
        }
    },
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/maximzhurkin/containers.git"
        }
    ]
}
```

### Install Containers with [composer](https://getcomposer.org/doc/00-intro.md):

```shell
composer update maximzhurkin/containers
```

### Publish vendor config

```shell
php artisan vendor:publish --provider="Maximzhurkin\Containers\Providers\ContainerServiceProvider"
```

### Add providers in bootstrap/providers.php:

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

### Create Container

```shell
php artisan app:container Order
```

*This will create files in containers/Order folder*

### Add created provider to bootstrap/providers.php configuration file

```php
use Containers\Order\Providers\OrderProvider;

return [
    //...
    OrderProvider::class,
];
```

### Add created routing class to config/containers.php configuration file

```php
use Containers\Order\Http\Routing\OrderRouting;

return [
    'routes' => [
        OrderRouting::class,
    ],
];
```

## Other commands

### Create container to exist container

```shell
php artisan app:container OrderStatus Order
```

### Create controller

```shell
php artisan app:controller User
```

*containers/User/Http/Controllers/UserController.php*

### Create factory

```shell
php artisan app:factory User
```

*containers/User/Data/Factories/UserFactory.php*

### Create migration

```shell
php artisan app:migration User
```

*containers/User/Data/Migrations/202406141352_create_users_table.php*

### Create model

```shell
php artisan app:model User
```

*containers/User/Models/User.php*

### Create provider

```shell
php artisan app:provider User
```

*containers/User/Providers/UserProvider.php*

### Create repository

```shell
php artisan app:repository User
```

*containers/User/Data/Repositories/UserRepository.php*

### Create request

```shell
php artisan app:request User
```

*containers/User/Http/Requests/UserRequest.php*

### Create routing

```shell
php artisan app:routing User
```

*containers/User/Http/Routing/UserRouting.php*
