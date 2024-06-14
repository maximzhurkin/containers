<?php

namespace Maximzhurkin\Containers\Commands;

class MakeRepositoryCommand extends MakeCommand
{
    protected $signature = 'app:repository {name} {container?}';
    protected $description = 'Create new repository';
    protected string $layer = 'Data/Repositories';
    protected string $stub = 'Repository.stub';

    protected function getFilename(): string
    {
        return $this->argument('name') . 'Repository';
    }
}
