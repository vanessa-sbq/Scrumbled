<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    public $action;
    public $method;
    public $label;
    /**
     * Create a new component instance.
     */
    public function __construct($action, $method = 'POST', $label = 'Submit')
    {
        $this->action = $action;
        $this->method = $method;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form');
    }
}
