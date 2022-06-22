<?php

namespace App\Observers;

use App\Model\Ekspedisi\Ekspedisi;
use Illuminate\Support\Facades\Auth;

class EkspedisiObserver
{
    /**
     * Handle the User "saving" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function saving(Ekspedisi $ekspedisi)
    {
        $ekspedisi->user_created = Auth::user()->id;
    }
}
