<?php

namespace App\Observers;

use App\Model\Iklan\Iklan;
use Illuminate\Support\Facades\Auth;

class IklanObserver
{   
    /**
     * Handle the Iklan "creating" event.
     *
     * @param  \App\Models\Iklan  $Iklan
     * @return void
     */
    public function creating(Iklan $param)
    {
        if (Auth::check()) {
            $param->user_created  = Auth::user()->id;
            $param->status_aktif = true;
        }
    }


    /**
     * Handle the Iklan "updating" event.
     *
     * @param  \App\Models\Iklan  $Iklan
     * @return void
     */
    public function updating(Iklan $param)
    {
        if (Auth::check()) {
            $param->updated_by  = Auth::user()->id;
        }
    }

}
