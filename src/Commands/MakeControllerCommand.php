<?php

namespace Maximzhurkin\Containers\Commands;

class MakeControllerCommand extends MakeCommand
{
    protected $signature = 'app:controller {name} {container?}';
    protected $description = 'Create new controller';
    protected string $layer = 'Http/Controllers';
    protected string $stub = 'Controller.stub';

    protected function getFilename(): string
    {
        return $this->argument('name') . 'Controller';
    }

    public function handle(): void
    {
        parent::handle();

        $this->call('app:request', [
            'name' => 'Store' . $this->argument('name'),
            'container' => $this->getContainer(),
        ]);
        $this->call('app:request', [
            'name' => 'Update' . $this->argument('name'),
            'container' => $this->getContainer(),
        ]);
    }
}
