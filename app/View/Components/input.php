<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class input extends Component
{
    /**
     * Create a new component instance.
     */
    public $title;
    public $name;
    public $data;
    public $type;

    public function __construct($title,$name,$data,$type)
    {
        $this->title=$title;
        $this->name=$name;
        $this->data=$data;
        $this->type=$type;



    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
