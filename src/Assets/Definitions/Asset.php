<?php

namespace Tlr\Display\Assets\Definitions;

class Asset
{
    /**
     * The scripts
     *
     * @var array
     */
    protected $scripts = [
        'default' => [],
    ];

    /**
     * The styles
     *
     * @var array
     */
    protected $styles = [
        'default' => [],
    ];

    /**
     * The asset's dependancies
     *
     * @var array
     */
    protected $dependancies = [];

    /**
     * Add an asset dependancy
     *
     * @param  string|array $names
     * @return \Tlr\Display\Assets\Definitions\Asset
     */
    public function dependsOn($names)
    {
        $this->dependancies = array_merge($this->dependancies, (array)$names);

        return $this;
    }

    /**
     * Add a script
     *
     * @return \Tlr\Display\Assets\Definitions\Batch
     */
    public function script($domain = 'default')
    {
        return $this->scripts[$domain][] = new Batch;
    }

    /**
     * Add a style
     *
     * @return \Tlr\Display\Assets\Definitions\Batch
     */
    public function style($domain = 'default')
    {
        return $this->styles[$domain][] = new Batch;
    }

    /**
     * Get the asset's dependancies
     *
     * @return array
     */
    public function dependancies()
    {
        return $this->dependancies;
    }

    /**
     * Get the asset's scripts
     *
     * @return array
     */
    public function scripts($domain = 'default')
    {
        return array_get($this->scripts, $domain, []);
    }

    /**
     * Get the asset's styles
     *
     * @return array
     */
    public function styles($domain = 'default')
    {
        return array_get($this->styles, $domain, []);
    }
}
