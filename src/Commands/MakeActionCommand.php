<?php

namespace Maximzhurkin\Containers\Commands;

class MakeActionCommand extends MakeCommand
{
    protected $signature = 'app:action {name} {container?}';
    protected $description = 'Create new action';
    protected string $layer = 'Actions';
    protected string $stub = 'Action.stub';

    protected function getFilename(): string
    {
        return $this->argument('name') . 'Action';
    }
}
