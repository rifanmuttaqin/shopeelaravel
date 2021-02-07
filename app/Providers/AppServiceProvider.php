<?php

namespace App\Providers;

use App\Model\HistoryCetak\HistoryCetak;
use App\Model\Setting\Setting;
use App\Observers\HistoryCetakObserver;
use Illuminate\Support\ServiceProvider;

use App\Observers\SettingObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Setting::observe(SettingObserver::class);
        HistoryCetak::observe(HistoryCetakObserver::class);
    }
}
