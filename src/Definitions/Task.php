<?php

namespace Tlr\Assets\Definitions;

use Assetic\Asset\AssetInterface;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;

class Task
{

	/**
	 * The files to filter
	 *
	 * @var array
	 */
	protected $files = [];

	/**
	 * The filters
	 *
	 * @var array
	 */
	protected $filters = [];

	/**
	 * Add a file
	 *
	 * @param  string $file
	 * @return
	 */
    public function file($file) {
    	return $this->addFile(new FileAsset($glob));
    }

    /**
     * Add a file glob
     *
     * @param  string $file
     * @return
     */
    public function glob($glob) {
    	return $this->addFile(new GlobAsset($glob));
    }

    /**
     * Add an http file
     *
     * @param  string $file
     * @return
     */
    public function link($url) {
    	return $this->addFile(new HttpAsset($url));
    }

    /**
     * Add an assetic file
     *
     * @param AssetCollectionInterface $file
     */
    public function addFile(AssetInterface $file) {
    	$this->files[] = $file;

    	return $this;
    }

    public function filter($name) {
    	// @todo set filter config
    	$this->filters[] = $name;
        return $this;
    }
}
