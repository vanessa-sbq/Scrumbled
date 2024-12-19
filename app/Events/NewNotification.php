<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $message;

    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->message = "NEW NOTIFICATION";
    }

    public function broadcastOn()
    {
        return 'user.' . $this->userId;
    }

    public function broadcastAs()
    {
        return 'new-notification';
    }
}
