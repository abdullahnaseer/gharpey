<?php

namespace App\Notifications\Buyer\ProductOrder;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductOrderCanceledNotification extends Notification
{
    use Queueable;

    private $productOrder;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($productOrder)
    {
        $this->productOrder = $productOrder;
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
            ->line('The order for product "' . $this->productOrder->product->name . '" is canceled.')
            ->action('Check Orders', url('/account/orders'))
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
            'message' => 'The order for product "' . $this->productOrder->product->name . '" is canceled.',
            'product_order_id' => $this->productOrder->id
        ];
    }
}
