<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeRepositoryCommandTest extends TestCase
{
    protected string $repositoryName;
    protected string $containerName;
    protected string $containerPath;
    protected string $repositoriesPath;
    protected string $contractsPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryName = 'TestRepository';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
        $this->repositoriesPath = "{$this->containerPath}/Data/Repositories";
        $this->contractsPath = "{$this->containerPath}/Contracts";

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
    public function it_can_create_repository_and_contract()
    {
        $this->artisan('app:repository', [
            'name' => $this->repositoryName,
            'container' => $this->containerName
        ])->assertSuccessful();

        // Проверка создания репозитория и контракта
        $repositoryPath = "{$this->repositoriesPath}/{$this->repositoryName}Repository.php";
        $contractPath = "{$this->contractsPath}/{$this->repositoryName}RepositoryContract.php";

        $this->assertTrue(File::exists($repositoryPath));
        $this->assertTrue(File::exists($contractPath));
    }
}
