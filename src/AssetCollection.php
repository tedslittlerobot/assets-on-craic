<?php

namespace Tlr\Assets;

use Tlr\Assets\Definitions\Asset;

class AssetCollection
{
    /**
     * The config callables
     *
     * @var array
     */
    protected $items = [];

    /**
     * The resolved asset cache
     *
     * @var array
     */
    protected $resolved = [];

    /**
     * Register a JS asset
     *
     * @param  string   $name
     * @param  callable $config
     * @return void
     */
    public function register($name, callable $config) {
        $this->items[$name] = $config;
    }

    /**
     * Get the list of config callables
     *
     * @return array
     */
    public function getCallables() {
        return $this->items;
    }

    /**
     * Get the config options for an asset
     *
     * @param  string $name
     * @return array
     */
    public function get($name) {
        if ($this->hasBeenResolved($name)) {
            return $this->getCached($name);
        }

        return $this->resolve($name);
    }

    /**
     * Check if the given asset has already been resolved
     *
     * @param  string  $name
     * @return boolean
     */
    public function hasBeenResolved($name) {
        return isset($this->resolved[$name]);

    }

    /**
     * Get a cached value
     *
     * @param  string $name
     * @return \Tlr\Assets\Definitions\Asset
     */
    public function getCached($name) {
        return $this->resolved[$name];
    }

    /**
     * Resolve and cache the given asset
     *
     * @param  string $name
     * @return \Tlr\Assets\Definitions\Asset
     */
    public function resolve($name) {
        // new config object
        $assetConfig = new Asset;

        // run the user config callable
        call_user_func($this->items[$name], $assetConfig);

        // cache and return
        return $this->resolved[$name] = $assetConfig;
    }

}
