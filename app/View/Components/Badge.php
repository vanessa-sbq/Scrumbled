<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public $type;
    public $value;

    public function __construct($type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.badge');
    }
}
