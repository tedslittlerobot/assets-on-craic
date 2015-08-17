<?php

namespace Tlr\Assets\Components;

use Illuminate\Contracts\Container\Container;
use Tlr\Assets\Components\AssetManager;

class ComponentLibrary
{

    /**
     * The registered components
     *
     * @var array
     */
    public function $componentMap = [];

    /**
     * The asset manager instance
     *
     * @var \Tlr\Assets\Components\AssetManager
     */
    protected $assets;

    /**
     * The application container instance
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    public function __construct(AssetManager $assets, Container $container, array $componentMap)
    {
        $this->assets = $assets;
        $this->container = $container;
        $this->componentMap = $componentMap;
    }

    /**
     * Construct a component
     *
     * @param  string $name
     * @param  array  $input
     * @return mixed
     */
    public function component($name, array $input = []) {
        $class = $this->componentMap;

        $component = $this->container->make($class, $input);

        $this->assets->activate($component->getAssets());

        return $component;
    }

    /**
     * Dynamically call a component view
     *
     * @param  string $method
     * @param  array  $arguments
     * @return \Illuminate\Contracts\Support\Htmlable
     */
    public function __call($method, array $arguments)
    {
        return $this->component(
            snake_case($method, '-'),
            array_get($arguments, 1, [])
        );
    }

}