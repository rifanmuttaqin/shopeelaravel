<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Pemasukan\Entities\Produk\Produk;

class ProdukObserver
{
    /**
     * Handle the User "saving" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function saving(Produk $produk)
    {
        $produk->user_created = Auth::user()->id;
    }
}
