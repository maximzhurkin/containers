<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeActionCommandTest extends TestCase
{
    protected string $actionName;
    protected string $containerName;
    protected string $containerPath;
    protected string $actionsPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actionName = 'TestAction';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
        $this->actionsPath = "{$this->containerPath}/Actions";

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
    public function it_can_create_action()
    {
        $this->artisan('app:action', [
            'name' => $this->actionName,
            'container' => $this->containerName
        ])->assertSuccessful();

        $expectedPath = "{$this->actionsPath}/{$this->actionName}Action.php";
        $this->assertTrue(File::exists($expectedPath));

        $content = File::get($expectedPath);

        // Проверка namespace и имени класса
        $this->assertStringContainsString("namespace Containers\\{$this->containerName}\Actions;", $content);
        $this->assertStringContainsString("class {$this->actionName}Action", $content);

        // Проверка структуры класса
        $this->assertStringContainsString('readonly class', $content);
        $this->assertStringContainsString('private', $content);
        $this->assertStringContainsString('public function run()', $content);

        // Проверка использования контракта репозитория
        $this->assertStringContainsString("use Containers\\{$this->containerName}\Contracts\\{$this->actionName}RepositoryContract;", $content);
        $this->assertStringContainsString("private {$this->actionName}RepositoryContract \$repository", $content);
    }
}
