<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeFactoryCommandTest extends TestCase
{
    protected string $factoryName;
    protected string $containerName;
    protected string $containerPath;
    protected string $factoriesPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factoryName = 'TestFactory';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
        $this->factoriesPath = "{$this->containerPath}/Data/Factories";

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
    public function it_can_create_factory()
    {
        $this->artisan('app:factory', [
            'name' => $this->factoryName,
            'container' => $this->containerName
        ])->assertSuccessful();

        $expectedPath = "{$this->factoriesPath}/{$this->factoryName}Factory.php";
        $this->assertTrue(File::exists($expectedPath));

        $content = File::get($expectedPath);

        // Проверка namespace и имени класса
        $this->assertStringContainsString("namespace Containers\\{$this->containerName}\\Data\\Factories;", $content);
        $this->assertStringContainsString("class {$this->factoryName}Factory extends Factory", $content);

        // Проверка импортов
        $this->assertStringContainsString("use Containers\\{$this->containerName}\\Models\\{$this->factoryName};", $content);
        $this->assertStringContainsString("use Illuminate\\Database\\Eloquent\\Factories\\Factory;", $content);

        // Проверка protected $model
        $this->assertStringContainsString("protected \$model = {$this->factoryName}::class;", $content);

        // Проверка метода definition
        $this->assertStringContainsString("public function definition(): array", $content);
    }
}
