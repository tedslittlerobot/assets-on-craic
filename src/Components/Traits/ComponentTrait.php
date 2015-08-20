<?php

namespace Tlr\Display\Components\Traits;

trait ComponentTrait
{
    use ViewComponentTrait, FluentComponentTrait, AssetComponentTrait;

    /**
     * Render the component in HTML
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->view($this->data)->render();
    }

    /**
     * Render the component to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }

}
