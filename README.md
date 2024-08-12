# Laravel Containers Package

A package with commands for a convenient Laravel project structure

```text
containers
├── Order
│   ├── Actions
│   │   ├── ListOrdersAction.php
│   │   └── ListOrderStatusesAction.php
│   ├── Contracts
│   │   ├── OrderRepositoryContract.php
│   │   └── OrderStatusRepositoryContract.php
│   ├── Data
│   │   ├── Factories
│   │   │   ├── OrderFactory.php
│   │   │   └── OrderStatusFactory.php
│   │   ├── Migrations
│   │   │   ├── 2024_06_14_123402_create_orders_table.php
│   │   │   └── 2024_06_14_135011_create_order_statuses_table.php
│   │   ├── Repositories
│   │   │   ├── OrderRepository.php
│   │   │   └── OrderStatusRepository.php
│   │   └── Seeders
│   │       ├── OrderSeeder.php
│   │       └── OrderStatusSeeder.php
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
│   ├── Providers
│   │   ├── OrderProvider.php
│   │   └── OrderStatusProvider.php
│   └── Tests
│       ├── Feature
│       │   ├── OrderTest.php
│       │   └── OrderStatusTest.php
│       └── Unit
│           ├── OrderTest.php
│           └── OrderStatusTest.php
└── User
    └── ...
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

### Add tests paths in phpunit.xml

```xml
<testsuites>
    <testsuite name="Unit">
        <directory>containers/*/Tests/Unit</directory>
    </testsuite>
    <testsuite name="Feature">
        <directory>containers/*/Tests/Feature</directory>
    </testsuite>
</testsuites>
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

### Create action

```shell
php artisan app:action User
```

*containers/User/Actions/UserAction.php*

> [!WARNING]  
> Specify the name of the entity so that the repository takes the correct name, then rename it to a specific action.

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

### Create seeder

```shell
php artisan app:seeder User
```

*containers/User/Data/Seeders/UserSeeder.php*

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

*containers/User/Contracts/UserRepositoryContract.php*

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

### Create test

```shell
php artisan app:test User
```

*containers/User/Tests/Feature/UserTest.php*

*containers/User/Tests/Unit/UserTest.php*
