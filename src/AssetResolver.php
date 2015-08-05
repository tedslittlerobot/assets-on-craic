<?php

namespace Tlr\Assets;

use Tlr\Assets\Definitions\Asset;

class AssetResolver
{
    /**
     * The asset collection instance
     *
     * @var \Tlr\Assets\AssetCollection
     */
    protected $assets;

    /**
     * The active assets
     *
     * @var array
     */
    protected $resolved = [];

    /**
     * A temporary variable for tracking active assets
     *
     * @var array
     */
    protected $tracked = [];

    public function __construct(AssetCollection $assets) {
        $this->assets = $assets;
    }

    /**
     * Recursively resolve an asset's dependancies. Returns an array where the
     * first item is the resolved scripts, and the second the resolved styles
     *
     * @param  string $name
     * @return \Tlr\Assets\AssetResolver
     */
    public function resolve($name)
    {
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
     * @return \Tlr\Assets\AssetResolver
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
    public function assets() {
        return $this->resolved;
    }

    /**
     * Determine if the given asset is tracked or resolved
     *
     * @param  \Tlr\Assets\Definitions\Asset  $asset
     * @return bool
     */
    protected function trackedOrResolved(Asset $asset) {
        return in_array($asset, $this->resolved) || in_array($asset, $this->tracked);
    }

    /**
     * Clear the resolver
     *
     * @return \Tlr\Assets\AssetResolver
     */
    public function clear() {
        $this->tracked = $this->resolved = [];

        return $this;
    }

}
