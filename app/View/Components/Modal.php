<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $title;
    public $classname;
    public $target;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?string $title, string $classname, string $target)
    {
        $this->title = $title;
        $this->classname = $classname;
        $this->target = $target;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
