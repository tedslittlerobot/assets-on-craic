<?php

use Assetic\Asset\AssetCollection as Assetic;
use Mockery as m;
use Tlr\Assets\AssetCollection;
use Tlr\Assets\AssetResolver;

class ScriptRenderTest extends PHPUnit_Framework_TestCase {

    public function tearDown() {
        m::close();
    }

    public function setUp() {
        $this->assets = new AssetCollection;
        $this->resolver = new AssetResolver($this->assets);
    }

    public function testBasicRender() {
        $this->assets->register('foo', function($asset) {
            $asset->script()
                ->file(__DIR__ . '/fixtures/foo.js')
                ->glob(__DIR__ . '/fixtures/other/*.js');
        });

        $this->resolver->resolve('foo');

        $output = [];

        foreach ($this->resolver->assets() as $asset) {

            foreach ($asset->scripts() as $script) {
                $output[] = (new Assetic($script->files(), $script->filters()))->dump();
            }

        }

        $this->assertEquals(file_get_contents(__DIR__ . '/fixtures/compiled.js'), implode('\n', $output));
    }

}
