<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStateChangeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $newState;

    /**
     * Create a new notification instance.
     *
     * @param  Order  $order
     * @param  string  $newState
     * @return void
     */
    public function __construct(Order $order, string $newState)
    {
        $this->order = $order;
        $this->newState = $newState;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['fcm']; // Changed to use FCM channel for Flutter application notifications
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order State Changed')
            ->line('The state of your order has been updated to: ' . $this->newState)
            ->action('View Order', url('/orders/' . $this->order->id))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'new_state' => $this->newState,
        ];
    }
}