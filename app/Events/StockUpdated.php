<?php

namespace App\Events;

use App\Models\Stock;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $stock;

    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    public function broadcastOn()
    {
        return new Channel('stocks');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->stock->id,
            'product_name' => $this->stock->product_name,
            'quantity' => $this->stock->quantity
        ];
    }
}