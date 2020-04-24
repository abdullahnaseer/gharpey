<?php

namespace App\Notifications;

use Closure;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class VerifyPhone extends Notification
{
    /**
     * The callback that should be used to build the mail message.
     *
     * @var Closure|null
     */
    public static $toMailCallback;

    private $guard;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($guard = 'buyer')
    {
        $this->guard = $guard;
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['nexmo'];
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param mixed $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        $verificationCode = $this->verificationCode($notifiable, $this->guard);

        return (new NexmoMessage())
            ->content('Your verification code is ' . $verificationCode);
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
     * @return string
     */
    protected function verificationCode($notifiable)
    {
        return $notifiable->phoneVerifyCode();
    }
}
