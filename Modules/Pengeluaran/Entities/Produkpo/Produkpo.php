<?php

namespace Modules\Pengeluaran\Entities\Produkpo;

use App\Scopes\GlobalScopeUSerCreated;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produkpo extends Model
{
      use HasFactory;

      protected $table        = 'tbl_produk_po';
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
            'harga',
            'status_aktif',
            'created_by',
            'updated_by'
      ];

      protected static function newFactory()
      {
            // return \Modules\Pengeluaran\Database\factories\Produkpo/ProdukpoFactory::new();
      }
}
