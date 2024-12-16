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
    public $saveAction;
    public $activeButtonColor;
    public $hoverButtonColor;

    /**
     * Create a new component instance.
     */
    public function __construct($title = 'Modal Title', $closeButtonText = 'Close', $saveButtonText = 'Save', $saveAction = 'saveModal', $activeButtonColor = 'bg-blue-600' , $hoverButtonColor = 'bg-blue-700')
    {
        $this->title = $title;
        $this->closeButtonText = $closeButtonText;
        $this->saveButtonText = $saveButtonText;
        $this->saveAction = $saveAction;
        $this->activeButtonColor = $activeButtonColor;
        $this->hoverButtonColor = $hoverButtonColor;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}