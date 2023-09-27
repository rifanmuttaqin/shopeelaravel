<?php

namespace App\Observers;

use App\Model\CashFlow\CashFlowTransaction;
use Illuminate\Support\Facades\Auth;

class CashFlowTransactionObserver
{   
    /**
     * Handle the Product "creating" event.
     *
     * @param  \App\Models\Product  $Product
     * @return void
     */
    public function creating(CashFlowTransaction $param)
    {
        if (Auth::check()) {
            $param->user_created  = Auth::user()->id;
            $param->status_aktif  = true;
        }
    }


    /**
     * Handle the Product "updating" event.
     *
     * @param  \App\Models\Product  $Product
     * @return void
     */
    public function updating(CashFlowTransaction $param)
    {
        
    }

}
