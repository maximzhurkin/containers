<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeTestFeatureCommandTest extends TestCase
{
    protected string $testName;
    protected string $containerName;
    protected string $containerPath;
    protected string $featureTestsPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testName = 'Test';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
        $this->featureTestsPath = "{$this->containerPath}/Tests/Feature";

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
    public function it_can_create_feature_test()
    {
        $this->artisan('app:test-feature', [
            'name' => $this->testName,
            'container' => $this->containerName
        ])->assertSuccessful();

        $featureTestPath = "{$this->featureTestsPath}/{$this->testName}Test.php";
        $this->assertTrue(File::exists($featureTestPath));
        $featureTestContent = File::get($featureTestPath);

        $this->assertStringContainsString("namespace Containers\\{$this->containerName}\\Tests\\Feature;", $featureTestContent);
        $this->assertStringContainsString("class {$this->testName}Test extends TestCase", $featureTestContent);
        $this->assertStringContainsString('use Tests\TestCase;', $featureTestContent);
        $this->assertStringContainsString('use Illuminate\Foundation\Testing\RefreshDatabase;', $featureTestContent);
        $this->assertStringContainsString('use RefreshDatabase;', $featureTestContent);
        $this->assertStringContainsString('public function test_test_returns_a_successful_response(): void', $featureTestContent);
        $this->assertStringContainsString('$response = $this->get(\'/api/v1/tests\');', $featureTestContent);
        $this->assertStringContainsString('$response->assertStatus(200);', $featureTestContent);
    }
}
