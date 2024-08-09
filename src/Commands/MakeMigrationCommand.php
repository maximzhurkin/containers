<?php

namespace Maximzhurkin\Containers\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class MakeMigrationCommand extends MakeCommand
{
    protected $signature = 'app:migration {name} {container?}';
    protected $description = 'Create new migration';
    protected string $layer = 'Data/Migrations';
    protected string $stub = 'Migration.stub';

    private function getNameWithSuffix(): string
    {
        $name = Str::snake($this->argument('name'));
        $suffix = str_ends_with($name, 's') ? 'es' : 's';

        return $name . $suffix;
    }

    protected function getFilename(): string
    {
        return Carbon::now()->format('Y_m_d_His') . '_create_' . $this->getNameWithSuffix() . '_table';
    }

    protected function getReplacedName(): string
    {
        return $this->getNameWithSuffix();
    }
}
