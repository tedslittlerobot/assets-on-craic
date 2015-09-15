<?php

namespace Tlr\Display\Components;

use Tlr\Display\Support\BladeCompilerExtender;

class ComponentBladeExtender extends BladeCompilerExtender
{

    /**
     * The directives to register
     *
     * @var array
     */
    protected $directives = ['wrapComponent', 'endWrapComponent'];

    /**
     * Open a component wrap
     *
     * @return string
     */
    public function wrapComponentDirective($expression)
    {
        return "<?php \$component = app('components')->component{$expression}->wrapContent(); ?>";
    }

    /**
     * Close a component wrap
     *
     * @return string
     */
    public function endWrapComponentDirective()
    {
        return '<?php $component->endWrapContent(); echo e($component); unset($component); ?>';
    }

}
