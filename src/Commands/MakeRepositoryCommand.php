<?php

namespace Maximzhurkin\Containers\Commands;

use Illuminate\Console\Command;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:repository {name} {container?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new repository';

    public function handle(): void
    {
        $this->call('app:repository-eloquent', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
        $this->call('app:repository-contract', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
    }
}
