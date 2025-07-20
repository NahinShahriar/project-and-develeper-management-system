<?php

namespace App\Listeners;

use App\Events\UserRegister;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\PasswordsetMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;


class UserSendMail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegister  $event
     * @return void
     */
    public function handle(UserRegister $event)
    {
            $user=$event->user;
             $random_password=$event->random_password;
            //  dd( $random_password);
            $token = Password::createToken($user);
            $link = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));
            Mail::to($user->email)->send(new PasswordsetMail( $user->name,$random_password,$link)); 
    }
}
