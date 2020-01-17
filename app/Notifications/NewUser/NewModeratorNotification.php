<?php

namespace App\Notifications\NewUser;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewModeratorNotification extends Notification
{
    use Queueable;

    /**
     * The password.
     *
     * @var string
     */
    public $password;

    /**
     * The officer.
     *
     * @var string
     */
    public $user;

    /**
     * Create a notification instance.
     *
     * @param string $token
     * @return void
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Invitation to join GharPey as Moderator')
            ->line('We are inviting you to join GharPey.pk')
            ->line('Email: ' . $this->email)
            ->line('Password: ' . $this->password)
            ->action('Login Now', route('moderator.login'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
