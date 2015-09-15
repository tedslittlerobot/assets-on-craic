<?php

namespace Tlr\Display\Components;

use Tlr\Display\Support\BladeCompilerExtender;

class ViewBladeExtender extends BladeCompilerExtender
{

    /**
     * The directives to register
     *
     * @var array
     */
    protected $directives = ['title'];

    /**
     * A blade directive for adding or overriding a global title variable
     * @param  string $title
     * @return string
     */
    public function titleDirective($title)
    {
        return '<?php $title = isset($title) ? $title : ' . $title . ' ?>';
    }

}
