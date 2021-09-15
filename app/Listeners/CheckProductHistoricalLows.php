<?php

namespace App\Listeners;

use App\Events\PriceSaved;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckProductHistoricalLows implements ShouldQueue
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
     * @param  PriceSaved  $event
     * @return void
     */
    public function handle(PriceSaved $event)
    {
        $product = Product::find($event->price->product_id);
        $product->historical_lowest_id = $event->price->id;
        $product->save();
    }

    /**
     * Determine whether the listener should be queued.
     *
     * @param PriceSaved $event
     * @return boolean
     */
    public function shouldQueue(PriceSaved $event)
    {
        return $event->price->lowest_price <= $event->price->product->historical_lowest_price->lowest_price;
    }
}
