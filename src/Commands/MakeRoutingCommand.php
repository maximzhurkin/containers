<?php

namespace Maximzhurkin\Containers\Commands;

class MakeRoutingCommand extends MakeCommand
{
    protected $signature = 'app:routing {name} {container?}';
    protected $description = 'Create new routing';
    protected string $layer = 'Http/Routing';
    protected string $stub = 'Routing.stub';

    protected function getFilename(): string
    {
        return $this->argument('name') . 'Routing';
    }
}
