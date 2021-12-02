<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Pengeluaran\Entities\TransaksiPo\TransaksiPoDetail;

class TransaksiPoDetailObserver
{
    /**
     * Handle the User "saving" event.
     *
     * @param  \App\Entities\TransaksiPo  $transaksi
     * @return void
     */
    public function saving(TransaksiPoDetail $transaksi)
    {
        $transaksi->user_created = Auth::user()->id;
    }
}