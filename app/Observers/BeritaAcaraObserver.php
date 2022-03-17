<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\BeritaAcara\Entities\BeritaAcara\BeritaAcara;

class BeritaAcaraObserver
{
    /**
     * Handle the User "saving" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function saving(BeritaAcara $param)
    {
        $param->user_created = Auth::user()->id;
    }
}
