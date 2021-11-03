<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportReady extends Notification
{
      use Queueable;

      public $user;


      /**
       * Create a new notification instance.
       *
       * @return void
       */
      public function __construct($user_model)
      {
            $this->user = $user_model;
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
       * Get the array representation of the notification.
       *
       * @param  mixed  $notifiable
       * @return array
       */
      public function toArray($notifiable)
      {
            return [
                  'name' => $this->user->nama,
                  'email' => $this->user->email,
            ];
      }
}
