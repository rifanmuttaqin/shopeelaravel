<?php

namespace App\Jobs;

use App\Model\User\User;
use App\Notifications\ImportReady;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserOfCompletedImport implements ShouldQueue
{
      use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

      public $user_model;

      /**
       * Create a new job instance.
       *
       * @return void
       */
      public function __construct(User $user)
      {
            $this->user_model = $user;
      }

      /**
       * Execute the job.
       *
       * @return void
       */
      public function handle()
      {
            $this->user_model->notify(new ImportReady($this->user_model));
      }
}
