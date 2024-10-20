<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $title;
    public $footer;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param string|null $footer
     */
    public function __construct($title, $footer = null)
    {
        $this->title = $title;
        $this->footer = $footer;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card');
    }
}
