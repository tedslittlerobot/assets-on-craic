<?php

use Mockery as m;
use Tlr\Assets\AssetCollection;
use Tlr\Assets\AssetRenderer;
use Tlr\Assets\AssetResolver;

class ScriptRenderTest extends PHPUnit_Framework_TestCase {

    public function tearDown() {
        m::close();
    }

    public function setUp() {
        $this->assets = new AssetCollection;
        $this->resolver = new AssetResolver($this->assets);
        $this->renderer = new AssetRenderer;
    }

    public function testBasicRender() {
        $this->assets->register('foo', function($asset) {
            $asset->script()
                ->file(__DIR__ . '/fixtures/foo.js')
                ->glob(__DIR__ . '/fixtures/other/*.js');
        });

        $this->resolver->resolve('foo');

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/compiled-basic.js'),
            $this->renderer->scripts($this->resolver->assets())
        );
    }

}
