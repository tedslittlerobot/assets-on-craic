<?php

use Mockery as m;
use Tlr\Display\Assets\AssetCollection;
use Tlr\Display\Assets\AssetRenderer;
use Tlr\Display\Assets\AssetResolver;

class StyleRenderTest extends PHPUnit_Framework_TestCase {

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
            $asset->style()
                ->file(__DIR__ . '/fixtures/foo.css');
        });
        $this->assets->register('bar', function($asset) {
            $asset->style()
                ->file(__DIR__ . '/fixtures/bar.css');
            $asset->dependsOn('foo');
        });

        $this->resolver->resolve('bar');

        $this->assertEquals(
            file_get_contents(__DIR__ . '/fixtures/compiled-basic.css'),
            $this->renderer->styles($this->resolver->assets())
        );
    }

}
