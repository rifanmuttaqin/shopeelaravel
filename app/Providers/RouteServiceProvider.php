<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * If specified, this namespace is automatically applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = null;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('web')
                ->namespace('App\Http\Controllers') 
                ->group(base_path('routes/web.php'));

            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::prefix('auth')
                ->middleware('web')
                ->namespace('App\Http\Controllers') 
                ->group(base_path('routes/master/auth.php'));

            Route::prefix('user')
                ->middleware('web')
                ->namespace('App\Http\Controllers') 
                ->group(base_path('routes/master/user.php'));

            Route::prefix('profile')
                ->middleware('web')
                ->namespace('App\Http\Controllers') 
                ->group(base_path('routes/master/profile.php'));

            Route::prefix('transaksi')
                ->middleware('web')
                ->namespace('App\Http\Controllers') 
                ->group(base_path('routes/master/transaksi.php'));

            Route::prefix('customer')
                ->middleware('web')
                ->namespace('App\Http\Controllers') 
                ->group(base_path('routes/master/customer.php'));

            Route::prefix('cetak')
                ->middleware('web')
                ->namespace('App\Http\Controllers') 
                ->group(base_path('routes/master/cetak.php'));

            Route::prefix('toko')
                ->middleware('web')
                ->namespace('App\Http\Controllers') 
                ->group(base_path('routes/master/toko.php'));

            Route::prefix('shopeepay')
                ->middleware('web')
                ->namespace('App\Http\Controllers') 
                ->group(base_path('routes/master/shopeepay.php'));

            Route::prefix('setting')
                ->middleware('web')
                ->namespace('App\Http\Controllers') 
                ->group(base_path('routes/master/setting.php'));
            
            Route::prefix('iklan')
                ->middleware('web')
                ->namespace('App\Http\Controllers') 
                ->group(base_path('routes/master/iklan.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
