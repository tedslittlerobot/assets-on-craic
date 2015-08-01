<?php

namespace Tcp\Support\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Expression;
use Tcp\Support\Components\AssetManager;

class ComponentLibrary
{

    /**
     * The asset manager instance
     *
     * @var \Tcp\Support\Components\AssetManager
     */
    protected $assets;

    public function __construct(AssetManager $assets)
    {
        $this->assets = $assets;
    }

    /**
     * Render a view. This is a macro of view and render
     *
     * @param  string $component
     * @param  array  $data
     * @param  array  $mergeData
     * @return \Illuminate\View\Expression
     */
    public function renderView($component, $data = [], $mergeData = [])
    {
        return $this->render(
            $this->view($component, $data, $mergeData)
        );
    }

    /**
     * Generate a view for the given component
     *
     * @param  string $component
     * @param  array  $data
     * @param  array  $mergeData
     * @return \Illuminate\View\View
     */
    public function view( $component, $data = [], $mergeData = [] )
    {
        return view('component-library.components.' . $component, $data, $mergeData);
    }

    /**
     * Render the given output
     *
     * @param  mixed $output
     * @return \Illuminate\View\Expression
     */
    public function render($output)
    {
        if($output instanceof Renderable) {
            $output = $output->render();
        }

        return new Expression($output);
    }

    /**
     * Dynamically call a component view
     *
     * @param  string $method
     * @param  array  $arguments
     * @return \Illuminate\View\Expression
     */
    public function __call($method, array $arguments)
    {
        $data = isset($arguments[0]) ? $arguments[0] : [];

        return $this->renderView(snake_case($method, '-'), $data);
    }

}
