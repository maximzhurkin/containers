<?php

namespace Maximzhurkin\Containers\Commands;

class MakeTestUnitCommand extends MakeCommand
{
    protected $signature = 'app:test-unit {name} {container?}';
    protected $description = 'Create new unit test';
    protected string $layer = 'Tests/Unit';
    protected string $stub = 'TestUnit.stub';

    protected function getFilename(): string
    {
        return $this->argument('name') . 'Test';
    }
}
