<?php

namespace App\Events;

use App\Http\Transformers\PumpTransformer;
use App\Pump;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReadFlagSet implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $target_type;
    public $target_id;

    /**
     * Create a new event instance.
     *
     * @param String $target_type
     * @param String $target_id
     */
    public function __construct($target_type, $target_id)
    {
        $this->target_type = $target_type;
        $this->target_id = $target_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('dashboard-updates');
    }
}
