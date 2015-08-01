<?php

namespace Tcp\Support\Components;

use Illuminate\View\Expression;
use Tcp\Support\Components\AssetManager;

class TagGenerator
{

    /**
     * The asset manager instnace
     *
     * @var \Tcp\Support\Components\AssetManager
     */
    protected $assets;

    public function __construct(AssetManager $assets)
    {
        $this->assets = $assets;
    }

    /**
     * Generate a script tag
     *
     * @return \Illuminate\View\Expression
     */
    public function scripts()
    {
        return $this->tag('<script src="%s"></script>', 'assets.js');
    }

    /**
     * Generate a style tag
     *
     * @return \Illuminate\View\Expression
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
        $query = $this->compileDependanciesQuery($this->assets->active());
        $url = route($route, [$query]);

        return $query ?
            $this->viewExpression( sprintf($format, $url) ) :
            null;
    }

    /**
     * Sort the links into their arrays
     *
     * @param  array $deps
     * @return string
     */
    public function compileDependanciesQuery(array $deps)
    {
        return implode('&', array_map(function($item) {
            return sprintf('sources[]=%s', urlencode($item));
        }, $deps));
    }

    /**
     * Generate a view expression
     *
     * @param  string $tag
     * @return \Illuminate\View\Expression
     */
    public function viewExpression($tag)
    {
        return new Expression($tag);
    }

}
