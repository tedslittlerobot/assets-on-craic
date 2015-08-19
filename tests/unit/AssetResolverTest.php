<?php

use Mockery as m;
use Tlr\Assets\Assets\AssetCollection;
use Tlr\Assets\Assets\AssetResolver;
use Tlr\Assets\Assets\Definitions\Asset;

class AssetResolverTest extends PHPUnit_Framework_TestCase {

    public function tearDown() {
        m::close();
    }

    public function setUp() {
        $this->assets = m::mock(AssetCollection::class);
        $this->resolver = new AssetResolver($this->assets);
    }

    public function testBasicResolve() {
        $this->assets->shouldReceive('get')->once()->with('foo')->andReturn($asset = m::mock(Asset::class));
        $asset->shouldReceive('dependancies')->once()->with()->andReturn([]);

        $this->resolver->resolve('foo');

        $this->assertSame([$asset], $this->resolver->assets());
    }

    public function testBasicDependanciesResolve() {
        $this->assets->shouldReceive('get')->once()->with('foo')->andReturn($asset = m::mock(Asset::class));
        $this->assets->shouldReceive('get')->once()->with('bar')->andReturn($dependancy = m::mock(Asset::class));

        $asset->shouldReceive('dependancies')->once()->with()->andReturn(['bar']);
        $dependancy->shouldReceive('dependancies')->once()->with()->andReturn([]);

        $this->resolver->resolve('foo');

        $this->assertSame([$dependancy, $asset], $this->resolver->assets());
    }

    public function testBasicDependanciesOnlyResolveOnce() {
        $this->assets->shouldReceive('get')->times(2)->with('foo')->andReturn($asset = m::mock(Asset::class));
        $asset->shouldReceive('dependancies')->once()->with()->andReturn([]);

        $this->resolver->resolve('foo');
        $this->resolver->resolve('foo');

        $this->assertSame([$asset], $this->resolver->assets());
    }

    public function testArrayResolves() {
        $this->assets->shouldReceive('get')->once()->with('foo')->andReturn($first = m::mock(Asset::class));
        $this->assets->shouldReceive('get')->once()->with('bar')->andReturn($second = m::mock(Asset::class));
        $first->shouldReceive('dependancies')->once()->with()->andReturn([]);
        $second->shouldReceive('dependancies')->once()->with()->andReturn([]);

        $this->resolver->resolveArray(['foo', 'bar']);

        $this->assertSame([$first, $second], $this->resolver->assets());
    }

    public function testClearResolved() {
        $this->assets->shouldReceive('get')->once()->with('foo')->andReturn($first = m::mock(Asset::class));
        $first->shouldReceive('dependancies')->once()->with()->andReturn([]);

        $this->resolver->resolve('foo');

        $this->assertSame([$first], $this->resolver->assets());

        $this->resolver->clear();

        $this->assertSame([], $this->resolver->assets());
    }
}
