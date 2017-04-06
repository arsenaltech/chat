<?php
namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\Channel;

/**
 * Created by PhpStorm.
 * User: shabbir
 * Date: 4/4/17
 * Time: 7:10 PM
 */
class NewMessage implements ShouldBroadcast
{
    public $from;
    public $to;
    public $message;

    public function __construct($message)
    {
        $this->from = $message->from;
        $this->to = $message->to;
        $this->message = $message->message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('App.User.'.$this->to->id);
    }
}