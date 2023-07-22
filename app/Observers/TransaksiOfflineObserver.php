<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Pemasukan\Entities\TransaksiOffline\TransaksiOffline;

class TransaksiOfflineObserver
{
     /**
     * Handle the Product "creating" event.
     *
     * @param  \App\Models\Product  $Product
     * @return void
     */
    public function creating(TransaksiOffline $param)
    {
        if (Auth::check()) {
            $param->user_created  = Auth::user()->id;
            $param->status_aktif = true;
        }
    }


    /**
     * Handle the Product "updating" event.
     *
     * @param  \App\Models\Product  $Product
     * @return void
     */
    public function updating(TransaksiOffline $param)
    {
        if (Auth::check()) {
            $param->updated_by  = Auth::user()->id;
        }
    }
}
