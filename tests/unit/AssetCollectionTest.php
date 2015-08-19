<?php

use Mockery as m;
use Tlr\Assets\Assets\AssetCollection;
use Tlr\Assets\Assets\AssetResolver;
use Tlr\Assets\Assets\Definitions\Asset;

class AssetCollectionTest extends PHPUnit_Framework_TestCase {

    public function tearDown() {
        m::close();
    }

    public function setUp() {
        $this->collection = new AssetCollection;
    }

    public function testRegisterCallable() {
        $this->collection->register('foo', $cb = function() {});

        $this->assertSame(['foo' => $cb], $this->collection->getCallables());
    }

    public function testBasicResolve() {
        $timesCalled = 0;
        $this->collection->register('foo', $cb = function(Asset $asset) use (&$timesCalled) {
            $timesCalled++;
        });

        $asset = $this->collection->get('foo');

        $this->assertTrue($asset instanceof Asset);
        $this->assertEquals(1, $timesCalled);
    }

    public function testCachedResolve() {
        $timesCalled = 0;
        $this->collection->register('foo', $cb = function(Asset $asset) use (&$timesCalled) {
            $timesCalled++;
        });

        $first = $this->collection->get('foo');
        $second = $this->collection->get('foo');

        $this->assertTrue($first instanceof Asset);
        $this->assertTrue($second instanceof Asset);
        $this->assertSame($first, $second);
        $this->assertEquals(1, $timesCalled);
    }

}
