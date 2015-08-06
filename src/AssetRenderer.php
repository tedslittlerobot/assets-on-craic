<?php

namespace Tlr\Assets;

use Assetic\Asset\AssetCollection as Assetic;
use Assetic\Asset\StringAsset;
use Tlr\Assets\Definitions\Asset;

class AssetRenderer
{
    /**
     * Render an asset set's scripts
     *
     * @param  array $assets
     * @return string
     */
    public function scripts($assets) {
        $outputs = [];

        foreach ((array)$assets as $asset) {
            foreach ($this->processScripts($asset) as $compiled) {
                $outputs[] = $compiled;
            }
        }

        return $this->finishScripts($outputs);
    }

    /**
     * Finish up script rendering
     *
     * @param  array  $scripts
     * @return string
     */
    public function finishScripts(array $scripts) {
        // @todo - allow hook to minify on production
        return $this->processAssetic($scripts, [], true);
    }

    /**
     * Proces the scripts of an asset
     *
     * @param  Asset  $asset
     * @return void
     */
    public function processScripts(Asset $asset) {
        foreach ($asset->scripts() as $script) {
            yield $this->processAssetic($script->files(), $script->filters());
        }
    }

    /**
     * Process an assetic batch
     *
     * @param  array  $sources
     * @param  array  $filters
     * @return \Assetic\Asset\StringAsset
     */
    public function processAssetic(array $sources, array $filters = [], $raw = false) {
        $content = (new Assetic($sources, $filters))->dump();

        return $raw ? $content : new StringAsset($content);
    }

}
