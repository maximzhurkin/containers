<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeRoutingCommandTest extends TestCase
{
    protected string $routingName;
    protected string $containerName;
    protected string $containerPath;
    protected string $routingPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->routingName = 'TestRouting';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
        $this->routingPath = "{$this->containerPath}/Http/Routing";

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
    public function it_can_create_routing()
    {
        $this->artisan('app:routing', [
            'name' => $this->routingName,
            'container' => $this->containerName
        ])->assertSuccessful();

        $routingPath = "{$this->routingPath}/{$this->routingName}Routing.php";
        $this->assertTrue(File::exists($routingPath));
        $routingContent = File::get($routingPath);

        $this->assertStringContainsString("namespace Containers\\{$this->containerName}\\Http\\Routing;", $routingContent);
        $this->assertStringContainsString("final class {$this->routingName}Routing implements RouteRegistrar", $routingContent);
        $this->assertStringContainsString('use Maximzhurkin\Containers\Contracts\RouteRegistrar;', $routingContent);
        $this->assertStringContainsString('use Illuminate\Support\Facades\Route;', $routingContent);
        $this->assertStringContainsString("use Containers\\{$this->containerName}\\Http\\Controllers\\{$this->routingName}Controller;", $routingContent);
        $this->assertStringContainsString('public static function map(): void', $routingContent);
        $this->assertStringContainsString("Route::middleware('api')", $routingContent);
        $this->assertStringContainsString("->prefix('/api/v1')", $routingContent);
        $this->assertStringContainsString("'/tests/routings'", $routingContent);
        $this->assertStringContainsString("Route::get('/', [{$this->routingName}Controller::class, 'index']);", $routingContent);
    }
}
