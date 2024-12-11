<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public $title;
    public $closeButtonText;
    public $saveButtonText;
    /**
     * Create a new component instance.
     */
    public function __construct($title = 'Modal Title', $closeButtonText = 'Close', $saveButtonText = 'Save')
    {
        $this->title = $title;
        $this->closeButtonText = $closeButtonText;
        $this->saveButtonText = $saveButtonText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
