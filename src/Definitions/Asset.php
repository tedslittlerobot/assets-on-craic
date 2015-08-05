<?php

namespace Tlr\Assets\Definitions;

class Asset
{
	/**
	 * The scripts
	 *
	 * @var array
	 */
	protected $scripts = [];

	/**
	 * The styles
	 *
	 * @var array
	 */
	protected $styles = [];

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
	 * @return Tlr\Assets\Definitions\Asset
	 */
	public function dependsOn($names) {
		$this->dependancies = array_merge($this->dependancies, (array)$names);

		return $this;
	}

	/**
	 * Add a script
	 *
	 * @return mixed
	 */
    public function script() {
        return $this->scripts[] = new Batch;
    }

    /**
     * Add a style
     *
     * @return mixed
     */
    public function style() {
        return $this->styles[] = new Batch;
    }

    /**
     * Get the asset's dependancies
     *
     * @return mixed
     */
    public function dependancies() {
        return $this->dependancies;
    }

    /**
     * Get the asset's scripts
     *
     * @return mixed
     */
    public function scripts() {
        return $this->scripts;
    }

    /**
     * Get the asset's styles
     *
     * @return mixed
     */
    public function styles() {
        return $this->styles;
    }
}
