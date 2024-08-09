<?php

namespace Maximzhurkin\Containers\Commands;

class MakeSeederCommand extends MakeCommand
{
    protected $signature = 'app:seeder {name} {container?}';
    protected $description = 'Create new seeder';
    protected string $layer = 'Data/Seeders';
    protected string $stub = 'Seeder.stub';

    protected function getFilename(): string
    {
        return $this->argument('name') . 'Seeder';
    }
}
