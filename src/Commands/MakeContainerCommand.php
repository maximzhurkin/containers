<?php

namespace Maximzhurkin\Containers\Commands;

use Illuminate\Console\Command;

class MakeContainerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:container {name} {container?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new container';

    public function handle(): void
    {
        $this->call('app:action', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
        $this->call('app:provider', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
        $this->call('app:model', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
        $this->call('app:migration', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
        $this->call('app:factory', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
        $this->call('app:seeder', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
        $this->call('app:repository', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
        $this->call('app:controller', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
        $this->call('app:routing', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
        $this->call('app:test', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
    }
}
