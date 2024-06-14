<?php

namespace Maximzhurkin\Containers\Commands;

class MakeRequestCommand extends MakeCommand
{
    protected $signature = 'app:request {name} {container?}';
    protected $description = 'Create new request';
    protected string $layer = 'Http/Requests';
    protected string $stub = 'Request.stub';

    protected function getFilename(): string
    {
        return $this->argument('name') . 'Request';
    }
}
