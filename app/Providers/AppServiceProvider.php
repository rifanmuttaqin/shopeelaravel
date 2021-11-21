<?php

namespace App\Providers;

use App\Model\HistoryCetak\HistoryCetak;
use App\Model\Setting\Setting;
use App\Model\Toko\Toko;
use App\Observers\HistoryCetakObserver;
use Illuminate\Support\ServiceProvider;

use App\Observers\SettingObserver;
use App\Observers\TokoObserver;
use App\Observers\TransaksiPoObserver;
use Illuminate\Support\Facades\Schema;
use Modules\Pengeluaran\Entities\TransaksiPo\TransaksiPo;
use Modules\Pengeluaran\Entities\TransaksiPo\TransaksiPoDetail;

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
      Schema::defaultStringLength(191);
      Setting::observe(SettingObserver::class);
      HistoryCetak::observe(HistoryCetakObserver::class);
      Toko::observe(TokoObserver::class);
      TransaksiPo::observe(TransaksiPoObserver::class);
    }
}
