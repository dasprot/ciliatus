<?php

namespace App\Events;

use App\Controlunit;
use App\Http\Transformers\ControlunitTransformer;
use App\Repositories\GenericRepository;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ControlunitUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $controlunit;

    /**
     * Create a new event instance.
     *
     * @param Controlunit $cu
     */
    public function __construct(Controlunit $cu)
    {
        $transformer = new ControlunitTransformer();

        $this->controlunit = $transformer->transform(
            (new GenericRepository($cu))->show()->toArray()
        );
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
