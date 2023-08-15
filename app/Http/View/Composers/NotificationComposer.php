<?php

namespace App\Http\View\Composers;

use App\Repositories\UserRepository;
use Illuminate\View\View;

class NotificationComposer
{
      /**
       * The user repository implementation.
       *
       * @var \App\Repositories\UserRepository
       */
      protected $unread;

      /**
       * Create a new composer.
       *
       * @param  \App\
       * @return void
       */
      public function __construct()
      {
            $unread = auth()->user()->unreadNotifications;

            // Dependencies are automatically resolved by the service container...
            $this->unread = $unread;
      }

      /**
       * Bind data to the view.
       *
       * @param  \Illuminate\View\View  $view
       * @return void
       */
      public function compose(View $view)
      {
            // dd($this->unread[0]->type);
            $view->with('unread', $this->unread);
      }
}