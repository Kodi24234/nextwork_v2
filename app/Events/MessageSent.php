<?php
namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
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
        // Broadcast to both users in the chat
        return [
            new PrivateChannel('chat.' . $this->message->chat_id),
            new PrivateChannel('user.' . $this->message->receiver_id),
        ];
    }

    public function broadcastWith()
    {
        return [
            'id'          => $this->message->id,
            'chat_id'     => $this->message->chat_id,
            'sender_id'   => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
            'body'        => $this->message->body,
            'created_at'  => $this->message->created_at,
            'sender'      => [
                'id'   => $this->message->sender->id,
                'name' => $this->message->sender->name,
            ],
        ];
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}
