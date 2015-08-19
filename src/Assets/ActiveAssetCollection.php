<?php

namespace Tlr\Assets\Assets;

use Tlr\Assets\Assets\AssetCollection;

class ActiveAssetCollection
{

    /**
     * The asset collection instance
     *
     * @var \Tlr\Assets\Assets\AssetCollection
     */
    protected $assets;

    /**
     * The active assets
     *
     * @var array
     */
    protected $active = [];

    public function __construct(AssetCollection $assets)
    {
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

}
