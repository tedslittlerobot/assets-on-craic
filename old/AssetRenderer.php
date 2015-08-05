<?php

namespace Tlr\Assets;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Filesystem\Filesystem;
use Tlr\Assets\Components\AssetManager;

class AssetRenderer
{

    /**
     * The asset manager instance
     *
     * @var \Tlr\Assets\Components\AssetManager
     */
    protected $assets;

    /**
     * The filesystem instnace
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The cache instnace
     *
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * Whether or not we are debugging
     *
     * @var boolean
     */
    protected $debug = true;

    public function __construct(AssetManager $assets, Filesystem $files, Repository $cache)
    {
        $this->assets = $assets;
        $this->files  = $files;
        $this->cache  = $cache;
    }

    /**
     * Get the scripts for the given dependancies
     *
     * @param  array  $dependancies
     * @return string
     */
    public function scripts(array $dependancies)
    {
        list($scripts,) = $this->assets->resolveArray($dependancies);

        return $this->get($scripts, 'scripts');
    }

    /**
     * Get the scripts for the given dependancies
     *
     * @param  array  $dependancies
     * @return string
     */
    public function styles(array $dependancies)
    {
        list(,$styles) = $this->assets->resolveArray($dependancies);

        return $this->get($styles, 'styles');
    }

    /**
     * Get the cached or fresh set of dependancies
     *
     * @param  array  $dependancies
     * @param  string $type
     * @return string
     */
    public function get(array $dependancies, $type)
    {
        $callback = function() use ($dependancies) {
            return $this->concatFiles($dependancies);
        };

        return $this->debug ?
            $this->concatFiles($dependancies) :
            $this->cache->rememberForever($this->cacheKey($type, $dependancies), $callback);
    }

    /**
     * Generate a cache key for the given arguments
     *
     * @param  string $type
     * @param  array  $dependancies
     * @return string
     */
    public function cacheKey($type, array $dependancies)
    {
        return sprintf('assets.%s.%s', $type, implode('-', $dependancies));
    }

    /**
     * Concat the given files
     *
     * @param  array $files
     * @return string
     */
    public function concatFiles(array $files)
    {
        $output = '';

        foreach ($files as $file) {
            if ($this->files->exists( $path = public_path($file) )) {
                $output .= $this->files->get($path);
            } else {
                throw new \Exception(sprintf('Error loading file in dependancy: %s', $file));
            }
        }

        return $output;
    }


}
