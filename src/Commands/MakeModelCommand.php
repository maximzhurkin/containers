<?php

namespace Maximzhurkin\Containers\Commands;

class MakeModelCommand extends MakeCommand
{
    protected $signature = 'app:model {name} {container?}';
    protected $description = 'Create new model';
    protected string $layer = 'Models';
    protected string $stub = 'Model.stub';
}
