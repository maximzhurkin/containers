<?php

namespace Maximzhurkin\Containers\Providers;

use Illuminate\Support\ServiceProvider;
use Maximzhurkin\Containers\Commands\MakeActionCommand;
use Maximzhurkin\Containers\Commands\MakeContainerCommand;
use Maximzhurkin\Containers\Commands\MakeControllerCommand;
use Maximzhurkin\Containers\Commands\MakeFactoryCommand;
use Maximzhurkin\Containers\Commands\MakeMigrationCommand;
use Maximzhurkin\Containers\Commands\MakeRepositoryCommand;
use Maximzhurkin\Containers\Commands\MakeRepositoryEloquentCommand;
use Maximzhurkin\Containers\Commands\MakeRepositoryContractCommand;
use Maximzhurkin\Containers\Commands\MakeSeederCommand;
use Maximzhurkin\Containers\Commands\MakeModelCommand;
use Maximzhurkin\Containers\Commands\MakeProviderCommand;
use Maximzhurkin\Containers\Commands\MakeRequestCommand;
use Maximzhurkin\Containers\Commands\MakeRoutingCommand;
use Maximzhurkin\Containers\Commands\MakeTestCommand;
use Maximzhurkin\Containers\Commands\MakeTestFeatureCommand;
use Maximzhurkin\Containers\Commands\MakeTestUnitCommand;

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
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeContainerCommand::class,
                MakeActionCommand::class,
                MakeControllerCommand::class,
                MakeFactoryCommand::class,
                MakeMigrationCommand::class,
                MakeSeederCommand::class,
                MakeModelCommand::class,
                MakeProviderCommand::class,
                MakeRepositoryCommand::class,
                MakeRepositoryEloquentCommand::class,
                MakeRepositoryContractCommand::class,
                MakeRequestCommand::class,
                MakeRoutingCommand::class,
                MakeTestCommand::class,
                MakeTestFeatureCommand::class,
                MakeTestUnitCommand::class,
            ]);
        }
    }
}
