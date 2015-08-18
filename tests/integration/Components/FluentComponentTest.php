<?php

use Mockery as m;

class FluentComponentTest extends PHPUnit_Framework_TestCase {

    public function tearDown() {
        m::close();
    }

    public function setUp() {
        $this->component = new FluentComponentTest_ComponentInstance;
    }

    public function testSet() {
        $this->component->set('foo', 'bar');

        $this->assertEquals('bar', $this->component->get('foo'));

        $this->component->set('foo', 'baz');

        $this->assertEquals('baz', $this->component->get('foo'));
    }

    public function testAppend() {
        $this->component->append('foo', 'bar');

        $this->assertEquals(['bar'], $this->component->get('foo'));
        $this->component->append('foo', 'baz');

        $this->assertEquals(['bar', 'baz'], $this->component->get('foo'));
    }

    public function testMagicSetAndAppend() {
        // set
        $this->component->foo('bar');

        $this->assertEquals('bar', $this->component->get('foo'));

        // covert to array and append
        $this->component->foo('baz', true);

        $this->assertEquals(['bar', 'baz'], $this->component->get('foo'));
    }

    public function testWrapContent() {

        $this->component->wrapContent();

            echo 'foo';

        $this->component->endWrapContent();

        $this->assertEquals('foo', $this->component->get('content'));
    }

}

class FluentComponentTest_ComponentInstance {
    use Tlr\Assets\Components\FluentComponentTrait;
}
