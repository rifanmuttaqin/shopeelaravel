<?php

namespace App\Observers;

use App\Model\Produk\Produk;
use Illuminate\Support\Facades\Auth;

class ProdukObserver
{   
    /**
     * Handle the Product "creating" event.
     *
     * @param  \App\Models\Product  $Product
     * @return void
     */
    public function creating(Produk $param)
    {
        if (Auth::check()) {
            $param->user_created  = Auth::user()->id;
        }
    }


    /**
     * Handle the Product "updating" event.
     *
     * @param  \App\Models\Product  $Product
     * @return void
     */
    public function updating(Produk $param)
    {
        if (Auth::check()) {
            $param->updated_by  = Auth::user()->id;
        }
    }

}
