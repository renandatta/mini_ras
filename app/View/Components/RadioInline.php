<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RadioInline extends Component
{
    public $name, $prefix, $caption, $options, $value;
    public function __construct($name, $caption = '', $prefix = '', $options = array(), $value = '')
    {
        $this->name = $name;
        $this->caption = $caption;
        $this->prefix = $prefix;
        $this->options = $options;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.radio-inline');
    }
}
