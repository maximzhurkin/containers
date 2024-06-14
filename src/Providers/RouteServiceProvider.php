<?php

namespace Maximzhurkin\Containers\Providers;

use Maximzhurkin\Containers\Contracts\RouteRegistrar;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use RuntimeException;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->routes(function (Registrar $router) {
            $this->mapRoutes($router, config('containers.routes'));
        });
    }

    protected function configureRateLimiting(): void
    {
        if (config('containers.rate_limiting.enabled')) {
            RateLimiter::for(config('containers.rate_limiting.for'), function (Request $request) {
                return Limit::perMinute(config('containers.rate_limiting.per_minute'))->by(
                    $request->user()?->id ?: $request->ip()
                );
            });
        }
    }

    protected function mapRoutes(Registrar $router, array $registrars): void
    {
        foreach ($registrars as $registrar) {
            if (
                ! class_exists($registrar) ||
                ! is_subclass_of($registrar, RouteRegistrar::class)
            ) {
                throw new RuntimeException(
                    sprintf(
                        'Cannot map routes \'%s\', it is not a valid routes class',
                        $registrar
                    )
                );
            }

            (new $registrar())->map($router);
        }
    }
}
