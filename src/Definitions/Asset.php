<?php

namespace Tlr\Assets\Definitions;

class Asset
{
    public function scripts() {
        return $this->scripts[] = new Task;
    }

    public function styles() {
        return $this->styles[] = new Task;
    }
}
