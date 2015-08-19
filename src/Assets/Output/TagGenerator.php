<?php

namespace Tlr\Assets\Assets\Output;

use Illuminate\Contracts\Routing\UrlGenerator;
use Tlr\Assets\Assets\Components\AssetManager;

class TagGenerator
{

    /**
     * The asset manager instnace
     *
     * @var \Tlr\Assets\Assets\Components\AssetManager
     */
    protected $assets;

    /**
     * The url generator instnace
     *
     * @var \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected $url;

    public function __construct(AssetManager $assets, UrlGenerator $url)
    {
        $this->assets = $assets;
        $this->url = $url;
    }

    /**
     * Generate a script tag
     *
     * @return string
     */
    public function scripts()
    {
        return $this->tag('<script src="%s"></script>', 'assets.js');
    }

    /**
     * Generate a style tag
     *
     * @return string
     */
    public function styles()
    {
        return $this->tag('<link rel="stylesheet" href="%s" />', 'assets.css');
    }

    /**
     * Generate a tag with the given format
     *
     * @param  string $format
     * @param  string $route
     * @return string
     */
    public function tag($format, $route)
    {
        $url = $this->route(
            $route,
            $this->assets->active()
        );

        return sprintf($format, $url);
    }

    /**
     * Generate the route for the resource
     *
     * @param  string $name
     * @param  array $query
     * @return string
     */
    public function route($name, array $query)
    {
        return $this->url
            ->route($name, $this->compileDependanciesQuery($query));
    }

    /**
     * Sort the links into their arrays
     *
     * @param  array $deps
     * @return string
     */
    public function compileDependanciesQuery(array $deps)
    {
        return implode('&', array_map(function($item)
    {
            return sprintf('sources[]=%s', urlencode($item));
        }, $deps));
    }

}
