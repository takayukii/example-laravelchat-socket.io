<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageCreatedEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $destinations = [];
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($destinations, $message)
    {
        $this->destinations = $destinations;
        $this->message = $message;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['chat'];
    }
}
