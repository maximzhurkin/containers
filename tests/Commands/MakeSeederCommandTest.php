<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeSeederCommandTest extends TestCase
{
    protected string $seederName;
    protected string $containerName;
    protected string $containerPath;
    protected string $seedersPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seederName = 'TestSeeder';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
        $this->seedersPath = "{$this->containerPath}/Data/Seeders";

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
    public function it_can_create_seeder()
    {
        $this->artisan('app:seeder', [
            'name' => $this->seederName,
            'container' => $this->containerName
        ])->assertSuccessful();

        $seederPath = "{$this->seedersPath}/{$this->seederName}Seeder.php";
        $this->assertTrue(File::exists($seederPath));
        $seederContent = File::get($seederPath);

        $this->assertStringContainsString("namespace Containers\\{$this->containerName}\\Data\\Seeders;", $seederContent);
        $this->assertStringContainsString("class {$this->seederName}Seeder extends Seeder", $seederContent);
        $this->assertStringContainsString("use Containers\\{$this->containerName}\\Models\\{$this->seederName};", $seederContent);
        $this->assertStringContainsString('use Illuminate\Database\Seeder;', $seederContent);
        $this->assertStringContainsString('public function run(): void', $seederContent);
        $this->assertStringContainsString("{$this->seederName}::factory()->create();", $seederContent);
    }
}
