<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
       
        return new Channel('chat.' . $this->message->to);
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }

    public function broadcastWith()
{
    return [
        'from'         => $this->message->from,
        'to'           => $this->message->to,
        'message'      => $this->message->message,
        'created_at'   => $this->message->created_at->toDateTimeString(),
        'formatted_time' => $this->message->created_at->format('h:i A'),
    ];
}



}
