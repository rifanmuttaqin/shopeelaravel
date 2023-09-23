<?php

namespace App\Observers;

use App\Model\CashFlow\CashFlowComponent;
use Illuminate\Support\Facades\Auth;

class CashFlowComponentObserver
{   
    /**
     * Handle the Product "creating" event.
     *
     * @param  \App\Models\Product  $Product
     * @return void
     */
    public function creating(CashFlowComponent $param)
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
    public function updating(CashFlowComponent $param)
    {
        if (Auth::check()) {
            $param->updated_by  = Auth::user()->id;
        }
    }

}
