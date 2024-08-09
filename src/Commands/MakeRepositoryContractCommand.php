<?php

namespace Maximzhurkin\Containers\Commands;

class MakeRepositoryContractCommand extends MakeCommand
{
    protected $signature = 'app:repository-contract {name} {container?}';
    protected $description = 'Create new repository contract';
    protected string $layer = 'Contracts';
    protected string $stub = 'RepositoryContract.stub';

    protected function getFilename(): string
    {
        return $this->argument('name') . 'RepositoryContract';
    }
}
