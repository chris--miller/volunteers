<?php

namespace App\Listeners;

use Mail;
use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendUserWelcome
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Send a user welcome email
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;
        
        try
        {
            Mail::send('emails/user-welcome', compact('user'), function ($message) use ($user)
            {
                $message->to($user->email, $user->name)->subject('Welcome to the Volunteer Database!');
            });
        }
        catch (\Exception $exception)
        {
            app('request')->session()->flash('warning', "Unable to send email confirmation, SMTP error. Please notify the administrator of this volunteer database.");
        }
    }
}
