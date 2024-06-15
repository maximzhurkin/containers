<?php

namespace Maximzhurkin\Containers\Providers;

use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Maximzhurkin\Containers\Contracts\RouteRegistrar;
use Maximzhurkin\Containers\Exceptions\RoutingNotDefinedException;
use Maximzhurkin\Containers\Exceptions\RoutingNotValidException;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        $this->routes(function (Registrar $router) {
            $this->mapRoutes($router, config('containers.routes'));
        });
    }

    protected function mapRoutes(Registrar $router, array $registrars): void
    {
        foreach ($registrars as $registrar) {
            if (! class_exists($registrar)) {
                throw new RoutingNotDefinedException($registrar);
            }
            if (! is_subclass_of($registrar, RouteRegistrar::class)) {
                throw new RoutingNotValidException($registrar);
            }

            (new $registrar())->map($router);
        }
    }
}
