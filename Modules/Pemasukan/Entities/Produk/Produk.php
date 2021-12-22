<?php

namespace Modules\Pemasukan\Entities\Produk;

use App\Scopes\GlobalScopeUSerCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table        = 'tbl_produk';
    protected $guard_name   = 'web';

    public $timestamps      = true;

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new GlobalScopeUSerCreated);

        static::deleting(function($var) {
                
                $relationMethods = [];

                foreach ($relationMethods as $relationMethod) {
                    if ($var->$relationMethod()->count() > 0) 
                    {
                            return false;
                    }
                }
        });
    }


    protected $fillable = [
        'nama_produk',
        'sku_induk',
        'harga',
        'harga_grosir_satu',
        'harga_grosir_dua',
        'minimal_pengambilan_satu',
        'minimal_pengambilan_dua',
        'is_grosir',
        'status_aktif'
    ];
    
    
}
