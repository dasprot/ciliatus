<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class AnimalFeedingEventDeleted
 * @package App\Events
 */
class AnimalFeedingEventDeleted implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $animal_feeding_id;


    /**
     * Create a new event instance.
     *
     * AnimalFeedingDeleted constructor.
     * @param String $animal_feeding_id
     */
    public function __construct($animal_feeding_id)
    {
        $this->animal_feeding_id = $animal_feeding_id;
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