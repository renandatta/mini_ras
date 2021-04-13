<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormGroup extends Component
{
    public $caption, $id, $groupclass;
    public function __construct($caption = '', $id = '', $groupclass = '')
    {
        $this->caption = $caption;
        $this->id = $id;
        $this->groupclass = $groupclass;
    }

    public function render()
    {
        return view('components.form-group');
    }
}
