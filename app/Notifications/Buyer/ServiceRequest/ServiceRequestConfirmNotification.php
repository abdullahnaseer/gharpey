<?php

namespace App\Notifications\Buyer\ServiceRequest;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceRequestConfirmNotification extends Notification
{
    use Queueable;

    private $serviceRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            ->line('The service request order for service "' . $this->serviceRequest->service->name . '" is confirmed.')
            ->action('Check Orders', route('buyer.account.service-requests.index'))
            ->line('Thank you for using our application!');
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
            'message' => 'The service request order for service "' . $this->serviceRequest->service->name . '" is confirmed.',
            'product_order_id' => $this->serviceRequest->id
        ];
    }
}
