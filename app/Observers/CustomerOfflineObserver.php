<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Pemasukan\Entities\CustomerOffline\CustomerOffline;

class CustomerOfflineObserver
{

    
    /**
     * Handle the User "saving" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(CustomerOffline $customer)
    {
        if(Auth::user())
        {
            $customer->user_created = Auth::user()->id;
        }
    }
}
