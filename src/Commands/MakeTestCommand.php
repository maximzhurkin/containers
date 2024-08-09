<?php

namespace Maximzhurkin\Containers\Commands;

use Illuminate\Console\Command;

class MakeTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test {name} {container?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new test';

    public function handle(): void
    {
        $this->call('app:test-unit', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
        $this->call('app:test-feature', [
            'name' => $this->argument('name'),
            'container' => $this->argument('container'),
        ]);
    }
}
