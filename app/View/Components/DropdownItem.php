<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropdownItem extends Component
{
    public $to;
    public $class;

    /**
     * Create a new component instance.
     *
     * @param string $to
     * @param string $class
     * @return void
     */
    public function __construct($to, $class = '')
    {
        $this->to = $to;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown-item');
    }
}
