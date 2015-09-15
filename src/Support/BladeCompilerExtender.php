<?php

namespace Tlr\Display\Support;

use Illuminate\View\Compilers\BladeCompiler;

class BladeCompilerExtender
{

    /**
     * The directives to register
     *
     * @var array
     */
    protected $directives = [];

    /**
     * The directives to register
     *
     * @var array
     */
    protected $extensions = [];

    /**
     * Register with the compiler
     *
     * @return null
     */
    public function register(BladeCompiler $compiler)
    {
        foreach ($this->directives as $directive) {
            $compiler->directive($directive, [$this, $directive . 'Directive']);
        }

        foreach ($this->extensions as $extension) {
            $compiler->extend([$this, $extension . 'Extension']);
        }
    }

}
