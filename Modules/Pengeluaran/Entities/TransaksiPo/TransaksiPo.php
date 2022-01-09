<?php

namespace Modules\Pengeluaran\Entities\TransaksiPo;

use App\Scopes\GlobalScopeUSerCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiPo extends Model
{
      use HasFactory;

      protected $table        = 'tbl_transaksi_po';
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
            'supplier_name',
            'total_amount',
            'discount_amount',
            'nota',
            'keterangan',
            'status_aktif',
            'user_created',
            'updated_by'
      ];

      public function detail()
      {
            return $this->hasMany(TransaksiPoDetail::class,'id_transaksi_po','id');
      }

}
