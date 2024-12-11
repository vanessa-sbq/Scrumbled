<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    public $links;
    /**
     * Create a new component instance.
     * 
     * @param array $links
     * @return void
     */
    public function __construct($links = [])
    {
        $this->links = $links;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown');
    }
}
