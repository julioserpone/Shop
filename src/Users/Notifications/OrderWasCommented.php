<?php

/*
 * This file is part of the Epikfy Shop package.
 *
 * (c) Julio Hernández <juliohernandezs@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Epikfy\Users\Notifications;

use Epikfy\Orders\Models\Order;
use Epikfy\Notifications\Parsers\Label;
use Illuminate\Notifications\Notification;

class OrderWasCommented extends Notification
{
    /**
     * The Epikfy order representation.
     *
     * @var Order
     */
    protected $order = null;

    /**
     * Create a new notification instance.
     *
     * @param Order $order
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $labelFed = [
            'source_id' => $this->order->id,
            'status' => 'new',
        ];

        return [
            'label' => Label::make('push.comments')->with($labelFed)->print(),
            'source_path' => $this->sourcePath($notifiable),
            'source_id' => $this->order->id,
            'status' => 'new',
        ];
    }

    /**
     * Returns the notification path.
     *
     * @param  mixed $notifiable
     *
     * @return string
     */
    protected function sourcePath($notifiable) //while refactoring
    {
        if ($notifiable->isAdmin()) {
            return route('orders.show_seller_order', $this->order);
        }

        return route('orders.show_order', $this->order);
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
            //
        ];
    }
}
