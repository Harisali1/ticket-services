<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PortalNotification extends Notification
{
    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'    => $this->data['type'],   // agency, booking, payment, pnr
            'title'   => $this->data['title'],
            'message' => $this->data['message'],
            'url'     => $this->data['url'],    // redirect URL
            'icon'    => $this->data['icon'] ?? 'bell',
        ];
    }
}

