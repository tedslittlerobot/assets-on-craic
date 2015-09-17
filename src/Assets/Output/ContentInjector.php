<?php

namespace Tlr\Display\Assets\Output;

use Illuminate\Contracts\Routing\UrlGenerator;
use Tlr\Display\Assets\AssetRenderer;
use Tlr\Display\Assets\AssetResolver;
use Tlr\Display\Assets\Components\AssetManager;

class TagInjector
{

    /**
     * The asset manager instnace
     *
     * @var \Tlr\Display\Assets\Components\AssetManager
     */
    protected $assets;

    /**
     * The url generator instnace
     *
     * @var \Tlr\Display\Assets\AssetResolver
     */
    protected $resolver;

    /**
     * The url generator instnace
     *
     * @var \Tlr\Display\Assets\AssetRenderer
     */
    protected $resolver;

    public function __construct(AssetManager $assets, AssetResolver $resolver, AssetRenderer $renderer)
    {
        $this->assets = $assets;
        $this->resolver = $resolver;
        $this->renderer = $renderer;
    }

    /**
     * Generate script output
     *
     * @return string
     */
    public function scripts($domain = 'default', array $options = [])
    {
        return '<script>' . $this->renderer->scripts( $this->resolve(), $domain ) . '</script>';
    }

    /**
     * Generate style output
     *
     * @return string
     */
    public function styles($domain = 'default', array $options = [])
    {
        return '<style>' . $this->renderer->styles( $this->resolve(), $domain ) . '</style>';
    }

    /**
     * Generate a tag with the given format
     *
     * @param  string $format
     * @param  string $route
     * @return string
     */
    public function resolve()
    {
        return $this->resolver
            ->clear()
            ->resolveArray($this->assets->active())
            ->assets();
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
