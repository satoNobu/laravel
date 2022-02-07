<?php

namespace App\Listeners;

use App\Events\XXXEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class YYYListener
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
     * @param  \App\Events\XXXEvent  $event
     * @return void
     */
    public function handle(XXXEvent $event)
    {
        //
    }
}
