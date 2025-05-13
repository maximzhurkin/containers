<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeControllerCommandTest extends TestCase
{
    protected string $controllerName;
    protected string $containerName;
    protected string $containerPath;
    protected string $controllersPath;
    protected string $requestsPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controllerName = 'TestController';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
        $this->controllersPath = "{$this->containerPath}/Http/Controllers";
        $this->requestsPath = "{$this->containerPath}/Http/Requests";

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
    public function it_can_create_controller_and_requests()
    {
        $this->artisan('app:controller', [
            'name' => $this->controllerName,
            'container' => $this->containerName
        ])->assertSuccessful();

        // Проверка создания контроллера
        $controllerPath = "{$this->controllersPath}/{$this->controllerName}Controller.php";
        $this->assertTrue(File::exists($controllerPath));

        $controllerContent = File::get($controllerPath);

        // Проверка namespace и имени класса контроллера
        $this->assertStringContainsString("namespace Containers\\{$this->containerName}\\Http\\Controllers;", $controllerContent);
        $this->assertStringContainsString("class {$this->controllerName}Controller", $controllerContent);

        // Проверка импортов
        $this->assertStringContainsString("use App\\Http\\Controllers\\Controller;", $controllerContent);
        $this->assertStringContainsString("use Containers\\{$this->containerName}\\Actions\\{$this->controllerName}Action;", $controllerContent);
        $this->assertStringContainsString("use Containers\\{$this->containerName}\\Data\\Repositories\\{$this->controllerName}Repository;", $controllerContent);
        $this->assertStringContainsString("use Containers\\{$this->containerName}\\Models\\{$this->controllerName};", $controllerContent);
        $this->assertStringContainsString("use Containers\\{$this->containerName}\\Http\\Requests\\Store{$this->controllerName}Request;", $controllerContent);
        $this->assertStringContainsString("use Containers\\{$this->containerName}\\Http\\Requests\\Update{$this->controllerName}Request;", $controllerContent);

        // Проверка методов контроллера
        $this->assertStringContainsString("public function index()", $controllerContent);
        $this->assertStringContainsString("public function store(Store{$this->controllerName}Request \$request)", $controllerContent);
        $this->assertStringContainsString("public function show({$this->controllerName} \$testController)", $controllerContent);
        $this->assertStringContainsString("public function update(Update{$this->controllerName}Request \$request, {$this->controllerName} \$testController)", $controllerContent);
        $this->assertStringContainsString("public function destroy({$this->controllerName} \$testController)", $controllerContent);

        // Проверка создания Request файлов
        $storeRequestPath = "{$this->requestsPath}/Store{$this->controllerName}Request.php";
        $updateRequestPath = "{$this->requestsPath}/Update{$this->controllerName}Request.php";

        $this->assertTrue(File::exists($storeRequestPath));
        $this->assertTrue(File::exists($updateRequestPath));
    }
}
