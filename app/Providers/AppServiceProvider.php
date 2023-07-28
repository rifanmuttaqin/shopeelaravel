<?php

namespace App\Providers;

use App\Interfaces\AdvertisementInterface;
use App\Interfaces\CustomerInterface;
use App\Model\Ekspedisi\Ekspedisi;
use App\Model\HistoryCetak\HistoryCetak;
use App\Model\Setting\Setting;
use App\Model\Toko\Toko;
use App\Observers\BeritaAcaraObserver;
use App\Observers\CustomerOfflineObserver;
use App\Observers\EkspedisiObserver;
use App\Observers\HistoryCetakObserver;
use App\Observers\ProdukObserver;

use App\Interfaces\ProductInterface;
use App\Interfaces\TransactionInterface;
use App\Model\Iklan\Iklan;
use App\Model\Produk\Produk;
use App\Observers\IklanObserver;
use Illuminate\Support\ServiceProvider;

use App\Observers\SettingObserver;
use App\Observers\TokoObserver;
use App\Observers\TransaksiOfflineObserver;
use App\Observers\TransaksiPoDetailObserver;
use App\Observers\TransaksiPoObserver;
use App\Repository\AdvertisementRepository;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use App\Repository\TransactionRepository;
use Illuminate\Support\Facades\Schema;
use Modules\BeritaAcara\Entities\BeritaAcara\BeritaAcara;
use Modules\Pemasukan\Entities\CustomerOffline\CustomerOffline;
use Modules\Pemasukan\Entities\TransaksiOffline\TransaksiOffline;
use Modules\Pengeluaran\Entities\TransaksiPo\TransaksiPo;
use Modules\Pengeluaran\Entities\TransaksiPo\TransaksiPoDetail;
use Modules\Pengeluaran\Interfaces\TransactionPoInterface;
use Modules\Pengeluaran\Repository\TransactionPoRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(TransactionInterface::class, TransactionRepository::class);
        $this->app->bind(CustomerInterface::class, CustomerRepository::class);
        $this->app->bind(AdvertisementInterface::class, AdvertisementRepository::class);
        $this->app->bind(TransactionPoInterface::class, TransactionPoRepository::class);
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
        Ekspedisi::observe(EkspedisiObserver::class);
        Iklan::observe(IklanObserver::class);
    }
}
