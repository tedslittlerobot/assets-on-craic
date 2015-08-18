<?php

namespace Tlr\Assets\Components;

trait ViewComponentTrait
{

    /**
     * The view name for this component
     *
     * @var string
     */
    protected $view;

    /**
     * The prefix to the view name
     *
     * @var string
     */
    protected $viewPrefix = 'component-library.components';

    /**
     * Generate a view for the given component
     *
     * @param  array  $data
     * @param  array  $mergeData
     * @return \Illuminate\View\View
     */
    public function view($data = [], $mergeData = []) {
        return view( $this->viewPrefix . '.' . $this->viewName(), $data, $mergeData);
    }

    /**
     * Get the view name
     *
     * @return string
     */
    public function viewName() {
        return $this->view ?: snake_case(get_class($this), '-');
    }

}
