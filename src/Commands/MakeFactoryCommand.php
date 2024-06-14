<?php

namespace Maximzhurkin\Containers\Commands;

class MakeFactoryCommand extends MakeCommand
{
    protected $signature = 'app:factory {name} {container?}';
    protected $description = 'Create new factory';
    protected string $layer = 'Data/Factories';
    protected string $stub = 'Factory.stub';

    protected function getFilename(): string
    {
        return $this->argument('name') . 'Factory';
    }
}
