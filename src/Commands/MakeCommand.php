<?php

namespace Maximzhurkin\Containers\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

abstract class MakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:entity {name} {container?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new entity';

    /**
     * Name Entity
     *
     * @var string
     */
    protected string $layer;


    /**
     * Stub filename
     *
     * @var string
     */
    protected string $stub;

    private function addSuffix($string): string
    {
        return $string . (str_ends_with($string, 's') ? 'es' : 's');
    }

    /**
     * Container name
     *
     * @return string
     */
    protected function getContainer(): string
    {
        if ($this->argument('container')) {
            return $this->argument('container');
        }

        return $this->argument('name');
    }

    /**
     * Get filename
     *
     * @return string
     */
    protected function getFilename(): string
    {
        return $this->argument('name');
    }

    /**
     * Replaced in stub
     *
     * @return string
     */
    protected function getReplacedName(): string
    {
        return $this->argument('name');
    }

    /**
     * Get full path to stub filename
     *
     * @return string
     * @throws Exception
     */
    protected function getStub(): string
    {
        if (!$this->stub) {
            throw new Exception('Stub not defined');
        }
        return __DIR__ . '/Stubs/' . $this->stub;
    }

    /**
     * Get layer path
     *
     * @return string
     * @throws Exception
     */
    protected function getLayerPath(): string
    {
        if (!$this->stub) {
            throw new Exception('Layer not defined');
        }
        return 'containers/' . $this->getContainer() . '/' . $this->layer;
    }

    protected function getNameWithSuffix(): string
    {
        return $this->addSuffix($this->argument('name'));
    }

    protected function getDummyUrlName(): string
    {
        $names = explode('_', Str::snake($this->argument('name')));

        return implode('/', array_map(function ($name) {
            return $this->addSuffix($name);
        }, $names));
    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $segments = explode('/', $this->getLayerPath());
        $filename = $this->getLayerPath() . '/' . $this->getFilename() . '.php';
        $destination = base_path();

        foreach ($segments as $segment) {
            $destination .= '/' . $segment;

            if (!File::exists($destination)) {
                File::makeDirectory($destination);
                $this->info('Folder ' . Str::replace(base_path() . '/', '', $destination) . ' create successful');
            }
        }

        if (!File::exists($filename)) {
            File::put($filename, Str::replace(
                [
                    'DummyContainer',
                    'DummyName',
                    'dummyName',
                    'dummyURLName'
                ],
                [
                    $this->getContainer(),
                    $this->getReplacedName(),
                    Str::lcfirst($this->getReplacedName()),
                    Str::lcfirst($this->getDummyUrlName())
                ],
                File::get($this->getStub())
            ));

            $this->info("File $filename make successful");
        } else {
            $this->warn("File $filename already exist");
        }
    }
}
