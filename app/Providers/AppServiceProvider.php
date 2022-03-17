<?php

namespace App\Providers;

use App\Model\HistoryCetak\HistoryCetak;
use App\Model\Setting\Setting;
use App\Model\Toko\Toko;
use App\Observers\BeritaAcaraObserver;
use App\Observers\CustomerOfflineObserver;
use App\Observers\HistoryCetakObserver;
use App\Observers\ProdukObserver;
use Illuminate\Support\ServiceProvider;

use App\Observers\SettingObserver;
use App\Observers\TokoObserver;
use App\Observers\TransaksiOfflineObserver;
use App\Observers\TransaksiPoDetailObserver;
use App\Observers\TransaksiPoObserver;
use Illuminate\Support\Facades\Schema;
use Modules\BeritaAcara\Entities\BeritaAcara\BeritaAcara;
use Modules\Pemasukan\Entities\CustomerOffline\CustomerOffline;
use Modules\Pemasukan\Entities\Produk\Produk;
use Modules\Pemasukan\Entities\TransaksiOffline\TransaksiOffline;
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
      TransaksiPoDetail::observe(TransaksiPoDetailObserver::class);
      Produk::observe(ProdukObserver::class);
      CustomerOffline::observe(CustomerOfflineObserver::class);
      BeritaAcara::observe(BeritaAcaraObserver::class);
      TransaksiOffline::observe(TransaksiOfflineObserver::class);
    }
}
