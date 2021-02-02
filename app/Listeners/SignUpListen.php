<?php

namespace App\Listeners;

use App\Events\SignUp;
use App\Mail\SignupMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SignUpListen implements ShouldQueue 
{
    public function handle(SignUp $event)
    {
        Mail::to($event->email)->send(new SignupMail($event->name));
    }
}
