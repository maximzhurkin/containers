<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;

class MakeMigrationCommandTest extends TestCase
{
    protected string $migrationName;
    protected string $containerName;
    protected string $containerPath;
    protected string $migrationsPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->migrationName = 'TestMigration';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path("containers/{$this->containerName}");
        $this->migrationsPath = "{$this->containerPath}/Data/Migrations";

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
    public function it_can_create_migration()
    {
        $this->artisan('app:migration', [
            'name' => $this->migrationName,
            'container' => $this->containerName
        ])->assertSuccessful();

        // Поиск файла миграции по маске
        $files = File::files($this->migrationsPath);
        $migrationFile = null;
        foreach ($files as $file) {
            if (preg_match('/\\d{4}_\\d{2}_\\d{2}_\\d{6}_create_test_migrations_table\\.php$/', $file->getFilename())) {
                $migrationFile = $file->getPathname();
                break;
            }
        }
        $this->assertNotNull($migrationFile, 'Migration file was not created');

        $content = File::get($migrationFile);

        // Проверка импортов
        $this->assertStringContainsString('use Illuminate\\Database\\Migrations\\Migration;', $content);
        $this->assertStringContainsString('use Illuminate\\Database\\Schema\\Blueprint;', $content);
        $this->assertStringContainsString('use Illuminate\\Support\\Facades\\Schema;', $content);

        // Проверка методов up и down
        $this->assertStringContainsString('public function up()', $content);
        $this->assertStringContainsString('public function down()', $content);

        // Проверка создания и удаления таблицы
        $this->assertStringContainsString("Schema::create('test_migrations'", $content);
        $this->assertStringContainsString("Schema::dropIfExists('test_migrations'", $content);
    }
}
