<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeTestUnitCommandTest extends TestCase
{
    protected string $testName;
    protected string $containerName;
    protected string $containerPath;
    protected string $unitTestsPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testName = 'Test';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
        $this->unitTestsPath = "{$this->containerPath}/Tests/Unit";

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
    public function it_can_create_unit_test()
    {
        $this->artisan('app:test-unit', [
            'name' => $this->testName,
            'container' => $this->containerName
        ])->assertSuccessful();

        $unitTestPath = "{$this->unitTestsPath}/{$this->testName}Test.php";
        $this->assertTrue(File::exists($unitTestPath));
        $unitTestContent = File::get($unitTestPath);

        $this->assertStringContainsString("namespace Containers\\{$this->containerName}\\Tests\\Unit;", $unitTestContent);
        $this->assertStringContainsString("class {$this->testName}Test extends TestCase", $unitTestContent);
        $this->assertStringContainsString("use Containers\\{$this->containerName}\\Models\\{$this->testName};", $unitTestContent);
        $this->assertStringContainsString('use Tests\TestCase;', $unitTestContent);
        $this->assertStringContainsString('use Illuminate\Foundation\Testing\RefreshDatabase;', $unitTestContent);
        $this->assertStringContainsString('use RefreshDatabase;', $unitTestContent);
        $this->assertStringContainsString('public function test_create_test_successful(): void', $unitTestContent);
        $this->assertStringContainsString("{$this->testName}::factory()->create([", $unitTestContent);
        $this->assertStringContainsString("'title' => 'Example',", $unitTestContent);
        $this->assertStringContainsString("\$test = {$this->testName}::first();", $unitTestContent);
        $this->assertStringContainsString("\$this->assertEquals('Example', \$test->title);", $unitTestContent);
    }
}
