<?php

namespace App\TestListeners;

use App\TestEvents\AAAEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BBBListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\TestEvents\AAAEvent  $event
     * @return void
     */
    public function handle(AAAEvent $event)
    {
        //
    }
}
