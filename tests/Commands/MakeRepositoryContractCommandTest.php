<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeRepositoryContractCommandTest extends TestCase
{
    protected string $repositoryName;
    protected string $containerName;
    protected string $containerPath;
    protected string $contractsPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryName = 'TestRepository';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
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
    public function it_can_create_repository_contract()
    {
        $this->artisan('app:repository-contract', [
            'name' => $this->repositoryName,
            'container' => $this->containerName
        ])->assertSuccessful();

        $contractPath = "{$this->contractsPath}/{$this->repositoryName}RepositoryContract.php";
        $this->assertTrue(File::exists($contractPath));
        $contractContent = File::get($contractPath);

        $this->assertStringContainsString("namespace Containers\\{$this->containerName}\\Contracts;", $contractContent);
        $this->assertStringContainsString("interface {$this->repositoryName}RepositoryContract", $contractContent);
        $this->assertStringContainsString('use Illuminate\Database\Eloquent\Collection;', $contractContent);
        $this->assertStringContainsString('public function getAll(): Collection;', $contractContent);
    }
}
