<?php

namespace Tcp\Support\Components;

class AssetBag
{
    /**
     * The files
     *
     * @var array
     */
    protected $items = [];

    /**
     * Add one or more items
     *
     * @param  array|string $items
     * @return \Tcp\Support\Components\AssetBag
     */
    public function add($items)
    {
        $this->items = array_merge($this->items, (array)$items);
        return $this;
    }

    /**
     * Get the config's items
     *
     * @return array
     */
    public function get()
    {
        return $this->items;
    }

}
