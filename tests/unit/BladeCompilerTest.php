<?php

use Mockery as m;

class BladeCompilerTest extends PHPUnit_Framework_TestCase {

    public function tearDown() {
        m::close();
    }

    public function setUp() {
        $this->callback = function($value) {
            return $value;
        };
    }

    public function testOpeningTag() {
        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/compiled.php'),
            call_user_func($this->callback, file_get_contents(__DIR__ . '/fixtures/compile.blade.php'))
        );
    }

}
