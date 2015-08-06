<?php

namespace Tlr\Assets;

use Assetic\Asset\AssetCollection as Assetic;
use Assetic\Asset\StringAsset;
use Tlr\Assets\Definitions\Asset;

class AssetRenderer
{
    /////// MAIN ENTRY POINTS ///////

    /**
     * Render an asset set's scripts
     *
     * @param  array $assets
     * @return string
     */
    public function scripts($assets) {
        return $this->finishScripts(
            $this->processAssetList((array)$assets, 'scripts')
        );
    }

    /**
     * Render an asset set's styles
     *
     * @param  array $assets
     * @return string
     */
    public function styles($assets) {
        return $this->finishStyles(
            $this->processAssetList((array)$assets, 'styles')
        );
    }

    /////// HOOKS ///////

    /**
     * Finish up script rendering
     *
     * @param  array  $scripts
     * @return string
     */
    public function finishScripts(array $scripts) {
        // @todo - allow hook to minify on production
        return $this->processAssetic($scripts);
    }

    /**
     * Finish up script rendering
     *
     * @param  array  $scripts
     * @return string
     */
    public function finishStyles(array $scripts) {
        // @todo - allow hook to minify on production
        return $this->processAssetic($scripts);
    }

    /////// ASSETIC PROCESSING HELPERS ///////

    /**
     * Loop through the assets, and process one type of asset
     *
     * @param  array  $assets
     * @param  string $type
     * @return array
     */
    public function processAssetList(array $assets, $type) {
        $outputs = [];

        foreach ((array)$assets as $asset) {
            foreach ($this->processBatches($asset->{$type}()) as $compiled) {
                $outputs[] = $compiled;
            }
        }

        return $outputs;
    }

    /**
     * Proces the a batch of assets
     *
     * @param  array  $batches
     * @return \Iterator
     */
    public function processBatches(array $batches) {
        foreach ($batches as $batch) {
            yield $this->processAssetic($batch->files(), $batch->filters(), false);
        }
    }

    /**
     * Process an assetic batch
     *
     * Pass true to return the raw content, otherwise it will return an assetic
     * asset representing the result
     *
     * @param  array  $sources
     * @param  array  $filters
     * @return mixed
     */
    public function processAssetic(array $sources, array $filters = [], $raw = true) {
        $content = (new Assetic($sources, $filters))->dump();

        return $raw ? $content : new StringAsset($content);
    }

}
