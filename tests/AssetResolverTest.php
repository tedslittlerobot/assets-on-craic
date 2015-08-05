<?php

use Mockery as m;
use Tlr\Assets\AssetCollection;
use Tlr\Assets\AssetResolver;
use Tlr\Assets\Definitions\Asset;

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

}
