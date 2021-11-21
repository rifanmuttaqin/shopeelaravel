<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Pengeluaran\Entities\TransaksiPo\TransaksiPo;

class TransaksiPoObserver
{
    /**
     * Handle the User "saving" event.
     *
     * @param  \App\Entities\TransaksiPo  $transaksi
     * @return void
     */
    public function saving(TransaksiPo $transaksi)
    {
        $transaksi->user_created = Auth::user()->id;
    }
}