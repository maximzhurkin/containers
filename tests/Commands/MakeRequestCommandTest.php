<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeRequestCommandTest extends TestCase
{
    protected string $requestName;
    protected string $containerName;
    protected string $containerPath;
    protected string $requestsPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->requestName = 'TestRequest';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
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
    public function it_can_create_request()
    {
        $this->artisan('app:request', [
            'name' => $this->requestName,
            'container' => $this->containerName
        ])->assertSuccessful();

        $requestPath = "{$this->requestsPath}/{$this->requestName}Request.php";
        $this->assertTrue(File::exists($requestPath));
        $requestContent = File::get($requestPath);

        $this->assertStringContainsString("namespace Containers\\{$this->containerName}\\Http\\Requests;", $requestContent);
        $this->assertStringContainsString("class {$this->requestName}Request extends FormRequest", $requestContent);
        $this->assertStringContainsString('use Illuminate\Contracts\Validation\ValidationRule;', $requestContent);
        $this->assertStringContainsString('use Illuminate\Foundation\Http\FormRequest;', $requestContent);
        $this->assertStringContainsString('public function authorize(): bool', $requestContent);
        $this->assertStringContainsString('return false;', $requestContent);
        $this->assertStringContainsString('public function rules(): array', $requestContent);
        $this->assertStringContainsString('return [', $requestContent);
        $this->assertStringContainsString('//', $requestContent);
    }
}
