<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{

    public $type;
    public $message;
    public $alertType;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $msg, $alertType)
    {
        $this->type = $type;
        $this->message = $msg;
        $this->alertType = $alertType;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');


        // return function (array $data) {
        //     // $data['componentName'];
        //     // $data['attributes'];
        //     // $data['slot'];
        //     // dd($data);
    
        //     return '<div>Components content</div>';
        // };
    }

}
