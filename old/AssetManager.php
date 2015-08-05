<?php

namespace Tlr\Assets;

class AssetManager
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
    protected $active = [];

    /**
     * The active assets
     *
     * @var array
     */
    protected $resolved = [];

    public function __construct(AssetCollection $assets) {
        $this->assets = $assets;
    }

    /**
     * The active assets
     *
     * @return array
     */
    public function active()
    {
        return $this->active;
    }

    /**
     * Clear the current active assets
     *
     * @return void
     */
    public function clearActive()
    {
        $this->active = [];
    }

    /**
     * Activate an asset
     *
     * @param  string $name
     * @return void
     */
    public function activate($name)
    {
        $this->active[] = $name;
    }

    /**
     * Resolve the currently active assets
     *
     * @return array
     */
    public function resolveActive()
    {
        return $this->resolveArray($this->active());
    }

    /**
     * Recursively resolve an asset's dependancies. Returns an array where the
     * first item is the resolved scripts, and the second the resolved styles
     *
     * @param  string $name
     * @return array
     */
    public function resolve($name)
    {
        if (isset($this->resolved[$name])) {
            return $this->resolved[$name];
        }

        $asset = $this->assets->get($name);

        $resolvedScripts = [];
        $resolvedStyles  = [];

        // resolve dependancies
        list($resolvedScripts, $resolvedStyles) = $this->resolveAndMerge($asset);

        // add files
        $resolvedScripts = array_merge($resolvedScripts, $scripts->get());
        $resolvedStyles  = array_merge($resolvedStyles, $styles->get());

        // cache and return
        return $this->resolved[$name] = [
            array_values( array_unique($resolvedScripts) ),
            array_values( array_unique($resolvedStyles) )
        ];
    }

    /**
     * Resolve some dependancies and merge the results into the passed arrays
     *
     * @param  array  $names
     * @param  array  $scripts
     * @param  array  $styles
     * @return array
     */
    protected function resolveAndMerge(array $names, Asset $asset)
    {
        foreach ($names as $name) {
            list($derivedScripts, $derivedStyles) = $this->resolve($name);

            $scripts = array_merge($scripts, $derivedScripts);
            $styles = array_merge($styles,  $derivedStyles);
        }

        return [$scripts, $styles];
    }

    /**
     * Resolve an array of assets
     *
     * @param  array  $names
     * @return array
     */
    public function resolveArray(array $names)
    {
        $scripts = [];
        $styles  = [];

        list($scripts, $styles) = $this->resolveAndMerge($names, $scripts, $styles);

        return [
            array_values( array_unique($scripts) ),
            array_values( array_unique($styles) )
        ];
    }

}
