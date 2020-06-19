<?php

namespace App\Notifications\Seller\ServiceRequest;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceRequestNotification extends Notification
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
            ->line('You have received a new service request.')
            ->action('Check Now', route('seller.orders.index'))
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
            'message' => 'New Order Received for product "' . $this->serviceRequest->service_seller->service->name . '"',
            'service_request_id' => $this->serviceRequest->id
        ];
    }
}
