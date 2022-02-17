<?php

namespace Dealskoo\Comment\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentDeleted extends Event
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
}
