<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignUp
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $email , $name; 
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($email , $name)
    {
        $this->email = $email; 
        $this->name =  $name;
    }
}
