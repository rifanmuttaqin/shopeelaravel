<?php

namespace App\Observers;

use App\Model\Setting\Setting;

use Auth;

class SettingObserver
{
    /**
     * Handle the User "saving" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function saving(Setting $setting)
    {
        $setting->user_id = Auth::user()->id;
    }
}
