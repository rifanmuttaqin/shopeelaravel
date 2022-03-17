<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Pemasukan\Entities\TransaksiOffline\TransaksiOffline;

class TransaksiOfflineObserver
{
     /**
     * Handle the User "saving" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function saving(TransaksiOffline $param)
    {
        $param->user_created = Auth::user()->id;
    }
}
