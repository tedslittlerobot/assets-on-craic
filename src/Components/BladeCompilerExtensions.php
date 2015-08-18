<?php

namespace Tlr\Assets\Components;

use Illuminate\View\Compilers\BladeCompiler;

class BladeCompilerExtensions
{

    /**
     * The directives to register
     *
     * @var array
     */
    protected $directives = ['wrapComponent', 'endWrapComponent'];

    /**
     * Register the compiler dircetives
     *
     * @return string
     */
    public function register(BladeCompiler $compiler) {
        foreach($this->directives as $directive) {
            $compiler->directive($directive, [$this, $directive]);
        }
    }

    /**
     * Open a component wrap
     *
     * @return string
     */
    public function wrapComponent($expression) {
        return "<?php \$component = app('components')->component{$expression}->wrapContent(); ?>";
    }

    /**
     * Close a component wrap
     *
     * @return string
     */
    public function endWrapComponent($expression) {
        return '<?php $component->endWrapContent(); echo e($component); unset($component); ?>';
    }

}
