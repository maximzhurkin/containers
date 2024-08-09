<?php

namespace Maximzhurkin\Containers\Commands;

class MakeTestFeatureCommand extends MakeCommand
{
    protected $signature = 'app:test-feature {name} {container?}';
    protected $description = 'Create new feature test';
    protected string $layer = 'Tests/Feature';
    protected string $stub = 'TestFeature.stub';

    protected function getFilename(): string
    {
        return $this->argument('name') . 'Test';
    }
}
