<?php

namespace Tlr\Assets\Assets\Definitions;

use Assetic\Asset\AssetInterface;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;
use Assetic\Filter\FilterInterface;

class Batch
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
    public function file($file)
    {
        return $this->addFile(new FileAsset($file));
    }

    /**
     * Add a file glob
     *
     * @param  string $glob
     * @return
     */
    public function glob($glob)
    {
        return $this->addFile(new GlobAsset($glob));
    }

    /**
     * Add an http file
     *
     * @param  string $url
     * @return
     */
    public function link($url)
    {
        return $this->addFile(new HttpAsset($url));
    }

    /**
     * Add an assetic file
     *
     * @param \Assetic\Asset\AssetInterface $file
     */
    public function addFile(AssetInterface $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Add a filter
     *
     * @param \Assetic\Filter\FilterInterface $filter
     * @return
     */
    public function filter(FilterInterface $filter)
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     * Get the files
     *
     * @return array
     */
    public function files()
    {
        return $this->files;
    }

    /**
     * Get the filters
     *
     * @return array
     */
    public function filters()
    {
        return $this->filters;
    }
}
