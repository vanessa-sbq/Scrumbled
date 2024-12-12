<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public $variant;
    public $size;
    public $href;
    public $class;
    /**
     * Create a new component instance.
     */
    public function __construct($variant = 'primary', $size = 'md', $href, $class = '')
    {
        $this->variant = $variant;
        $this->size = $size;
        $this->href = $href;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
