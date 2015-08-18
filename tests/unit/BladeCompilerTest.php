<?php

use Mockery as m;

class BladeCompilerTest extends PHPUnit_Framework_TestCase {

    public function tearDown() {
        m::close();
    }

    public function setUp() {
        $this->compiler = new \Illuminate\View\Compilers\BladeCompiler(
            $this->filesystem = m::mock(\Illuminate\Filesystem\Filesystem::class),
            null
        );
    }

    public function testOpeningTag() {
        (new Tlr\Assets\Components\BladeCompilerExtensions)->register($this->compiler);

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/compiled.php'),
            $this->compiler->compileString(file_get_contents(__DIR__ . '/fixtures/compile.blade.php'))
        );
    }

}
