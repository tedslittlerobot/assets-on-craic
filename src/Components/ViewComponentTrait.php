<?php

namespace Tlr\Assets\Components;

trait ViewComponentTrait
{

    /**
     * The prefix to the view name
     *
     * @var string
     */
    protected $viewPrefix = 'component-library.components';

    /**
     * Generate a view for the given component
     *
     * @param  string $component
     * @param  array  $data
     * @param  array  $mergeData
     * @return \Illuminate\View\View
     */
    public function view($name, $data = [], $mergeData = []) {
        return view( $this->viewPrefix . '.' . $this->viewName($name), $data, $mergeData);
    }

    /**
     * Get the view name
     *
     * @param  string $name
     * @return string
     */
    public function viewName($name) {
        if ($name) {
            return $name;
        }

        if (isset($this->view)) {
            return $this->view;
        }

        return snake_case(get_class($this), '-');
    }

}
