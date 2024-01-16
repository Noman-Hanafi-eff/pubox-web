<?php

namespace Modules\Product\Listeners;

use Modules\Product\Events\ProductViewed;

class IncrementProductView
{
    /**
     * Handle the event.
     *
     * @param ProductViewed $event
     *
     * @return void
     */
    public function handle(ProductViewed $event)
    {
        $event->product->increment('viewed');
    }
}
