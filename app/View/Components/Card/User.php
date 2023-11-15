<?php

namespace App\View\Components\Card;

use Illuminate\View\Component;

class User extends Component
{
    public $user;
    public $count;
    public $type;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $user, int $count, int $type)
    {
        $this->user = $user;
        $this->count = $count;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card.user');
    }
}
