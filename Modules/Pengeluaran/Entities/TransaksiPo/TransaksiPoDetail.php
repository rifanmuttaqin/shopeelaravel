<?php

namespace Modules\Pengeluaran\Entities\TransaksiPo;

use App\Scopes\GlobalScopeUSerCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiPoDetail extends Model
{
      use HasFactory;

      protected $table        = 'tbl_transaksi_po_detail';
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
            'id_transaksi_po',
            'nama_produk',
            'harga_produk',
            'qty_beli',
            'status_aktif',
            'created_by',
            'updated_by'
      ];

}
