<?php

namespace App\Observers;

use App\Model\Toko\Toko;
use Illuminate\Support\Facades\Auth;

class TokoObserver
{
    /**
     * Handle the User "saving" event.
     *
     * @param  \App\Models\Toko  $user
     * @return void
     */
    public function saving(Toko $toko)
    {
        $toko->user_id = Auth::user()->id;
    }
}
