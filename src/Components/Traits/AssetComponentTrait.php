<?php

namespace Tlr\Assets\Components\Traits;

trait AssetComponentTrait
{
    /**
     * The assets the component uses
     *
     * @var string|array
     */
    protected $assets;

    /**
     * Get the assets the component uses
     *
     * @return array
     */
    public function getAssets() {
        return (array)$this->assets;
    }

}
