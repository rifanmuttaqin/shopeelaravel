<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

use App\Model\User\User;
use App\Model\User\UserAttempt;

class ClearLoginAttempt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:attempt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pembersihan Login Attempt Setelah 15 Menit';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user_attempt = UserAttempt::all();
        
        foreach ($user_attempt as $user) 
        {
           $minutes = abs(strtotime($user->created_at) - time()) / 60;

           if($minutes >= 15)
           {
               $user_login = User::findOrFail($user->user_id);
               $user_login->status = User::USER_STATUS_ACTIVE;
               $user_login->save();
               $user->delete();
           }
        }
       
    }
}
