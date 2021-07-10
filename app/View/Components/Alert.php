<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type, $id, $display;
    public function __construct($type = '', $id = '', $display = false)
    {
        $this->type = $type;
        $this->id = $id;
        $this->display = $display;
    }

    public function render()
    {
        return view('components.alert');
    }
}
