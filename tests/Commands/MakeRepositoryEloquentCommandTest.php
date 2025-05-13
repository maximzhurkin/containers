<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeRepositoryEloquentCommandTest extends TestCase
{
    protected string $repositoryName;
    protected string $containerName;
    protected string $containerPath;
    protected string $repositoriesPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryName = 'TestRepository';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
        $this->repositoriesPath = "{$this->containerPath}/Data/Repositories";

        if (File::exists($this->containerPath)) {
            File::deleteDirectory($this->containerPath);
        }
    }

    protected function tearDown(): void
    {
        if (File::exists($this->containerPath)) {
            File::deleteDirectory($this->containerPath);
        }

        parent::tearDown();
    }

    #[Test]
    public function it_can_create_repository_eloquent()
    {
        $this->artisan('app:repository-eloquent', [
            'name' => $this->repositoryName,
            'container' => $this->containerName
        ])->assertSuccessful();

        $repositoryPath = "{$this->repositoriesPath}/{$this->repositoryName}Repository.php";
        $this->assertTrue(File::exists($repositoryPath));
        $repositoryContent = File::get($repositoryPath);

        $this->assertStringContainsString("namespace Containers\\{$this->containerName}\\Data\\Repositories;", $repositoryContent);
        $this->assertStringContainsString("class {$this->repositoryName}Repository implements {$this->repositoryName}RepositoryContract", $repositoryContent);
        $this->assertStringContainsString("use Containers\\{$this->containerName}\\Contracts\\{$this->repositoryName}RepositoryContract;", $repositoryContent);
        $this->assertStringContainsString("use Containers\\{$this->containerName}\\Models\\{$this->repositoryName};", $repositoryContent);
        $this->assertStringContainsString('use Illuminate\Database\Eloquent\Collection;', $repositoryContent);
        $this->assertStringContainsString('public function getAll(): Collection', $repositoryContent);
        $this->assertStringContainsString("return {$this->repositoryName}::all();", $repositoryContent);
    }
}