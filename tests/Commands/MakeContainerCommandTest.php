<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeContainerCommandTest extends TestCase
{
    protected string $containerName;
    protected string $containerPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->containerName = 'TestContainer';
        $this->containerPath = base_path('containers/' . $this->containerName);

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
    public function it_can_create_container_structure()
    {
        $this->artisan('app:container', [
            'name' => 'Test',
            'container' => $this->containerName,
        ])->assertSuccessful();

        // Проверяем создание основных директорий
        $this->assertTrue(File::exists("{$this->containerPath}/Actions"));
        $this->assertTrue(File::exists("{$this->containerPath}/Providers"));
        $this->assertTrue(File::exists("{$this->containerPath}/Models"));
        $this->assertTrue(File::exists("{$this->containerPath}/Data/Migrations"));
        $this->assertTrue(File::exists("{$this->containerPath}/Data/Factories"));
        $this->assertTrue(File::exists("{$this->containerPath}/Data/Seeders"));
        $this->assertTrue(File::exists("{$this->containerPath}/Data/Repositories"));
        $this->assertTrue(File::exists("{$this->containerPath}/Http/Controllers"));
        $this->assertTrue(File::exists("{$this->containerPath}/Http/Routing"));
        $this->assertTrue(File::exists("{$this->containerPath}/Tests/Feature"));
        $this->assertTrue(File::exists("{$this->containerPath}/Tests/Unit"));

        // Проверяем создание основных файлов
        $this->assertTrue(File::exists("{$this->containerPath}/Actions/TestAction.php"));
        $this->assertTrue(File::exists("{$this->containerPath}/Providers/TestProvider.php"));
        $this->assertTrue(File::exists("{$this->containerPath}/Models/Test.php"));
        $this->assertTrue(File::exists("{$this->containerPath}/Data/Factories/TestFactory.php"));
        $this->assertTrue(File::exists("{$this->containerPath}/Data/Seeders/TestSeeder.php"));
        $this->assertTrue(File::exists("{$this->containerPath}/Data/Repositories/TestRepository.php"));
        $this->assertTrue(File::exists("{$this->containerPath}/Contracts/TestRepositoryContract.php"));
        $this->assertTrue(File::exists("{$this->containerPath}/Http/Controllers/TestController.php"));
        $this->assertTrue(File::exists("{$this->containerPath}/Http/Routing/TestRouting.php"));
        $this->assertTrue(File::exists("{$this->containerPath}/Tests/Feature/TestTest.php"));
        $this->assertTrue(File::exists("{$this->containerPath}/Tests/Unit/TestTest.php"));

        // Проверяем наличие миграции
        $migrations = File::files("{$this->containerPath}/Data/Migrations");
        $this->assertCount(1, $migrations);
        $this->assertStringContainsString('create_tests_table', $migrations[0]->getFilename());
    }
}
