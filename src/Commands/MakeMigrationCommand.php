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

    protected function getFilename(): string
    {
        return Carbon::now()->format('Y_m_d_His') . '_create_' . $this->getReplacedName() . '_table';
    }

    protected function getReplacedName(): string
    {
        return Str::snake($this->getNameWithSuffix());
    }
}
