<?php

namespace Maximzhurkin\Containers\Tests\Commands;

use Maximzhurkin\Containers\Commands\MakeCommand;
use Maximzhurkin\Containers\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Output\BufferedOutput;

class TestMakeCommand extends MakeCommand
{
    protected string $layer = 'Actions';
    protected string $stub = 'Action.stub';
    protected $signature = 'app:test {name} {container?}';

    public function getFilename(): string
    {
        return $this->argument('name') . 'Action';
    }

    public function getContainer(): string
    {
        return parent::getContainer();
    }

    public function getReplacedName(): string
    {
        return parent::getReplacedName();
    }

    public function getNameWithSuffix(): string
    {
        return parent::getNameWithSuffix();
    }

    public function getDummyUrlName(): string
    {
        return parent::getDummyUrlName();
    }

    public function getLayerPath(): string
    {
        return parent::getLayerPath();
    }

    public function getStub(): string
    {
        return parent::getStub();
    }
}

class TestMakeCommandWithoutStub extends MakeCommand
{
    protected string $layer = 'Actions';
    protected $signature = 'app:test {name} {container?}';
    protected string $stub = '';

    public function getStub(): string
    {
        return parent::getStub();
    }
}

class TestMakeCommandWithoutLayer extends MakeCommand
{
    protected string $stub = 'Action.stub';
    protected $signature = 'app:test {name} {container?}';
    protected string $layer = '';

    public function getLayerPath(): string
    {
        return parent::getLayerPath();
    }
}

class MakeCommandTest extends TestCase
{
    protected string $commandName;
    protected string $containerName;
    protected string $containerPath;
    protected string $layerPath;
    protected MakeCommand $command;
    protected InputDefinition $definition;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandName = 'Test';
        $this->containerName = 'TestContainer';
        $this->containerPath = base_path('containers/' . $this->containerName);
        $this->layerPath = 'Actions';

        $this->definition = new InputDefinition([
            new InputArgument('name', InputArgument::REQUIRED),
            new InputArgument('container', InputArgument::OPTIONAL),
        ]);

        $this->command = new TestMakeCommand();
        $this->command->setOutput(new OutputStyle(new ArrayInput([]), new BufferedOutput()));

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
    public function it_can_get_container_name()
    {
        $this->command->setLaravel($this->app);
        $input = new ArrayInput([
            'name' => $this->commandName,
            'container' => $this->containerName
        ], $this->definition);
        $this->command->setInput($input);

        $this->assertEquals($this->containerName, $this->command->getContainer());
    }

    #[Test]
    public function it_can_get_container_name_from_name_argument()
    {
        $this->command->setLaravel($this->app);
        $input = new ArrayInput([
            'name' => $this->commandName
        ], $this->definition);
        $this->command->setInput($input);

        $this->assertEquals($this->commandName, $this->command->getContainer());
    }

    #[Test]
    public function it_can_get_filename()
    {
        $this->command->setLaravel($this->app);
        $input = new ArrayInput([
            'name' => $this->commandName
        ], $this->definition);
        $this->command->setInput($input);

        $this->assertEquals($this->commandName . 'Action', $this->command->getFilename());
    }

    #[Test]
    public function it_can_get_replaced_name()
    {
        $this->command->setLaravel($this->app);
        $input = new ArrayInput([
            'name' => $this->commandName
        ], $this->definition);
        $this->command->setInput($input);

        $this->assertEquals($this->commandName, $this->command->getReplacedName());
    }

    #[Test]
    public function it_can_get_name_with_suffix()
    {
        $this->command->setLaravel($this->app);
        $input = new ArrayInput([
            'name' => $this->commandName
        ], $this->definition);
        $this->command->setInput($input);

        $this->assertEquals($this->commandName . 's', $this->command->getNameWithSuffix());
    }

    #[Test]
    public function it_can_get_dummy_url_name()
    {
        $this->command->setLaravel($this->app);
        $input = new ArrayInput([
            'name' => 'TestEntity'
        ], $this->definition);
        $this->command->setInput($input);

        $this->assertEquals('tests/entitys', $this->command->getDummyUrlName());
    }

    #[Test]
    public function it_can_get_layer_path()
    {
        $this->command->setLaravel($this->app);
        $input = new ArrayInput([
            'name' => $this->commandName,
            'container' => $this->containerName
        ], $this->definition);
        $this->command->setInput($input);

        $this->assertEquals(
            'containers/' . $this->containerName . '/' . $this->layerPath,
            $this->command->getLayerPath()
        );
    }

    #[Test]
    public function it_can_create_directories_and_file()
    {
        $this->command->setLaravel($this->app);
        $input = new ArrayInput([
            'name' => $this->commandName,
            'container' => $this->containerName
        ], $this->definition);
        $this->command->setInput($input);

        $this->command->handle();

        $this->assertTrue(File::exists("{$this->containerPath}/{$this->layerPath}"));
        $this->assertTrue(File::exists("{$this->containerPath}/{$this->layerPath}/{$this->commandName}Action.php"));

        $content = File::get("{$this->containerPath}/{$this->layerPath}/{$this->commandName}Action.php");
        $this->assertStringContainsString("namespace Containers\\{$this->containerName}\\{$this->layerPath};", $content);
        $this->assertStringContainsString("class {$this->commandName}Action", $content);
    }

    #[Test]
    public function it_throws_exception_when_stub_not_defined()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Stub not defined');

        $command = new TestMakeCommandWithoutStub();
        $command->setLaravel($this->app);
        $command->setOutput(new OutputStyle(new ArrayInput([]), new BufferedOutput()));
        $input = new ArrayInput([
            'name' => $this->commandName
        ], $this->definition);
        $command->setInput($input);
        $command->getStub();
    }

    #[Test]
    public function it_throws_exception_when_layer_not_defined()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Layer not defined');

        $command = new TestMakeCommandWithoutLayer();
        $command->setLaravel($this->app);
        $command->setOutput(new OutputStyle(new ArrayInput([]), new BufferedOutput()));
        $input = new ArrayInput([
            'name' => $this->commandName
        ], $this->definition);
        $command->setInput($input);
        $command->getLayerPath();
    }
}
