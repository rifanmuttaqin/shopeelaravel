<?php

namespace App\Observers;

use App\Model\HistoryCetak\HistoryCetak;
use Illuminate\Support\Facades\Auth;

class HistoryCetakObserver
{
    /**
     * Handle the User "saving" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function saving(HistoryCetak $history_cetak)
    {
        $history_cetak->user_created = Auth::user()->id;
    }
}
