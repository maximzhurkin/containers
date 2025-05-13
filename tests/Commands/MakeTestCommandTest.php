<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeTestCommandTest extends TestCase
{
    protected string $testName;
    protected string $containerName;
    protected string $containerPath;
    protected string $featureTestsPath;
    protected string $unitTestsPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testName = 'Test';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
        $this->featureTestsPath = "{$this->containerPath}/Tests/Feature";
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
    public function it_can_create_feature_and_unit_tests()
    {
        $this->artisan('app:test', [
            'name' => $this->testName,
            'container' => $this->containerName
        ])->assertSuccessful();

        // Проверка создания feature и unit тестов
        $featureTestPath = "{$this->featureTestsPath}/{$this->testName}Test.php";
        $unitTestPath = "{$this->unitTestsPath}/{$this->testName}Test.php";

        $this->assertTrue(File::exists($featureTestPath));
        $this->assertTrue(File::exists($unitTestPath));
    }
}
