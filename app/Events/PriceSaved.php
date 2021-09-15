<?php

namespace App\Events;

use App\Models\Price;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PriceSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $price;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Price $price)
    {
        $this->price = $price;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
