<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeProviderCommandTest extends TestCase
{
    protected string $providerName;
    protected string $containerName;
    protected string $containerPath;
    protected string $providersPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->providerName = 'TestProvider';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
        $this->providersPath = "{$this->containerPath}/Providers";

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
    public function it_can_create_provider()
    {
        $this->artisan('app:provider', [
            'name' => $this->providerName,
            'container' => $this->containerName
        ])->assertSuccessful();

        $expectedPath = "{$this->providersPath}/{$this->providerName}Provider.php";
        $this->assertTrue(File::exists($expectedPath));

        $content = File::get($expectedPath);

        // Проверка namespace и имени класса
        $this->assertStringContainsString("namespace Containers\\{$this->containerName}\Providers;", $content);
        $this->assertStringContainsString("class {$this->providerName}Provider", $content);

        // Проверка наследования
        $this->assertStringContainsString("extends ServiceProvider", $content);

        // Проверка импортов
        $this->assertStringContainsString("use Illuminate\\Support\\ServiceProvider;", $content);
        $this->assertStringContainsString("use Containers\\{$this->containerName}\\Http\\Routing\\{$this->providerName}Routing;", $content);

        // Проверка методов
        $this->assertStringContainsString("public function register(): void", $content);
        $this->assertStringContainsString("public function boot(): void", $content);

        // Проверка загрузки миграций и вызова Routing::map()
        $this->assertStringContainsString("->loadMigrationsFrom", $content);
        $this->assertStringContainsString("{$this->providerName}Routing::map();", $content);
    }
}
