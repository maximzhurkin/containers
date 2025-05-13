<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeModelCommandTest extends TestCase
{
    protected string $modelName;
    protected string $containerName;
    protected string $containerPath;
    protected string $modelsPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->modelName = 'TestModel';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
        $this->modelsPath = "{$this->containerPath}/Models";

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
    public function it_can_create_model()
    {
        $this->artisan('app:model', [
            'name' => $this->modelName,
            'container' => $this->containerName
        ])->assertSuccessful();

        $expectedPath = "{$this->modelsPath}/{$this->modelName}.php";
        $this->assertTrue(File::exists($expectedPath));

        $content = File::get($expectedPath);

        // Проверка namespace и имени класса
        $this->assertStringContainsString("namespace Containers\\{$this->containerName}\\Models;", $content);
        $this->assertStringContainsString("class {$this->modelName} extends Model", $content);

        // Проверка импортов
        $this->assertStringContainsString("use Containers\\{$this->containerName}\\Data\\Factories\\{$this->modelName}Factory;", $content);
        $this->assertStringContainsString("use Illuminate\\Database\\Eloquent\\Concerns\\HasUuids;", $content);
        $this->assertStringContainsString("use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;", $content);
        $this->assertStringContainsString("use Illuminate\\Database\\Eloquent\\Model;", $content);

        // Проверка use трейтов
        $this->assertStringContainsString('use HasUuids;', $content);
        $this->assertStringContainsString('use HasFactory;', $content);

        // Проверка fillable
        $this->assertStringContainsString("protected \$fillable = [", $content);
        $this->assertStringContainsString("'title'", $content);

        // Проверка метода factory
        $this->assertStringContainsString("public static function factory(): {$this->modelName}Factory", $content);
        $this->assertStringContainsString("return {$this->modelName}Factory::new();", $content);
    }
}
