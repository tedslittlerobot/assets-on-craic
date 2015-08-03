<?php

namespace Tlr\Assets;

class AssetManager
{

    /**
     * The active assets
     *
     * @var array
     */
    protected $active = [];

    /**
     * The config callables
     *
     * @var array
     */
    protected $config = [];

    /**
     * The asset cache
     *
     * @var array
     */
    protected $configCache = [];

    /**
     * The cached resolved assets
     *
     * @var array
     */
    protected $resolutionCache = [];

    /**
     * Register a JS asset
     *
     * @param  string   $name
     * @param  callable $config
     * @return \Tlr\Assets\Components\AssetManager
     */
    public function register($name, callable $config)
    {
        $this->config[$name] = $config;

        return $this;
    }

    /**
     * Get the list of config callables
     *
     * @return array
     */
    public function getConfigCallables()
    {
        return $this->config;
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
        if (isset($this->resolutionCache[$name])) {
            return $this->resolutionCache[$name];
        }

        list($scripts, $styles, $dependancies) = $this->resolveConfig($name);

        $resolvedScripts = [];
        $resolvedStyles  = [];

        // resolve dependancies
        list($resolvedScripts, $resolvedStyles) = $this->resolveAndMerge(
            $dependancies->get(), $resolvedScripts, $resolvedStyles
        );

        // add files
        $resolvedScripts = array_merge($resolvedScripts, $scripts->get());
        $resolvedStyles  = array_merge($resolvedStyles, $styles->get());

        // cache and return
        return $this->resolutionCache[$name] = [
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
    protected function resolveAndMerge(array $names, array $scripts = [], array $styles = [])
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

    /**
     * Get the config options for an asset
     *
     * @param  string $name
     * @return array
     */
    public function resolveConfig($name)
    {
        if (isset($this->configCache[$name])) {
            return $this->configCache[$name];
        }

        // new config bags
        $scripts       = new AssetBag;
        $styles        = new AssetBag;
        $dependancies  = new AssetBag;

        // run the user config callable
        call_user_func($this->config[$name], $scripts, $styles, $dependancies);

        // cache and return
        return $this->configCache[$name] = [$scripts, $styles, $dependancies];
    }

}
