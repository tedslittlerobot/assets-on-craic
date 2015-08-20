<?php

namespace Tlr\Display\Assets;

use Tlr\Display\Assets\Definitions\Asset;

class AssetResolver
{
    /**
     * The asset collection instance
     *
     * @var \Tlr\Display\Assets\AssetCollection
     */
    protected $assets;

    /**
     * The active assets
     *
     * @var array
     */
    protected $resolved = [];

    /**
     * A temporary variable for tracking already processed assets
     *
     * @var array
     */
    protected $tracked = [];

    public function __construct(AssetCollection $assets)
    {
        $this->assets = $assets;
    }

    /**
     * Recursively resolve an asset's dependancies. Returns an array where the
     * first item is the resolved scripts, and the second the resolved styles
     *
     * @param  string $name
     * @return \Tlr\Display\Assets\AssetResolver
     */
    public function resolve($name)
    {
        if (is_array($name)) {
            return $this->resolveArray($name);
        }

        $asset = $this->assets->get($name);

        if ($this->trackedOrResolved($asset)) {
            return $this;
        }

        $this->tracked[] = $asset;

        // resolve dependancies
        foreach ($asset->dependancies() as $dependancy) {
            $this->resolve($dependancy);
        }

        $this->resolved[] = $asset;

        return $this;
    }

    /**
     * Resolve an array of assets
     *
     * @param  array  $names
     * @return \Tlr\Display\Assets\AssetResolver
     */
    public function resolveArray(array $names)
    {
        foreach ($names as $name) {
            $this->resolve($name);
        }

        return $this;
    }

    /**
     * Get the resolved assets
     *
     * @return array
     */
    public function assets()
    {
        return $this->resolved;
    }

    /**
     * Determine if the given asset is tracked or resolved
     *
     * @param  \Tlr\Display\Assets\Definitions\Asset  $asset
     * @return bool
     */
    protected function trackedOrResolved(Asset $asset)
    {
        return $this->inArray($asset, $this->resolved) || $this->inArray($asset, $this->tracked);
    }

    /**
     * An override for in_array, fixing a nesting level with some php internal
     * functions
     *
     * @param  mixed  $needle
     * @param  array  $haystack
     * @return bool
     */
    protected function inArray($needle, array $haystack)
    {
        foreach ($haystack as $item) {
            if ($item === $needle) {
                return true;
            }
        }

        return false;
    }

    /**
     * Clear the resolver
     *
     * @return \Tlr\Display\Assets\AssetResolver
     */
    public function clear()
    {
        $this->tracked = $this->resolved = [];

        return $this;
    }

}
