<?php

namespace Maximzhurkin\Containers\Providers;

use Illuminate\Support\ServiceProvider;
use Maximzhurkin\Containers\Commands\MakeContainerCommand;
use Maximzhurkin\Containers\Commands\MakeControllerCommand;
use Maximzhurkin\Containers\Commands\MakeFactoryCommand;
use Maximzhurkin\Containers\Commands\MakeMigrationCommand;
use Maximzhurkin\Containers\Commands\MakeModelCommand;
use Maximzhurkin\Containers\Commands\MakeProviderCommand;
use Maximzhurkin\Containers\Commands\MakeRepositoryCommand;
use Maximzhurkin\Containers\Commands\MakeRequestCommand;
use Maximzhurkin\Containers\Commands\MakeRoutingCommand;

class ContainerServiceProvider extends ServiceProvider
{
    public function __construct($dispatcher = null)
    {
        parent::__construct($dispatcher);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/containers.php' => config_path('containers.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeContainerCommand::class,
                MakeControllerCommand::class,
                MakeFactoryCommand::class,
                MakeMigrationCommand::class,
                MakeModelCommand::class,
                MakeProviderCommand::class,
                MakeRepositoryCommand::class,
                MakeRequestCommand::class,
                MakeRoutingCommand::class,
            ]);
        }
    }
}
