<?php

namespace Maximzhurkin\Containers\Commands;

class MakeProviderCommand extends MakeCommand
{
    protected $signature = 'app:provider {name} {container?}';
    protected $description = 'Create new provider';
    protected string $layer = 'Providers';
    protected string $stub = 'Provider.stub';

    protected function getFilename(): string
    {
        return $this->argument('name') . 'Provider';
    }
}
