<?php

namespace Modules\Pengeluaran\Entities\TransaksiPo;

use App\Scopes\GlobalScopeUSerCreated;
use Carbon\Carbon;
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
            'date',
            'extra_amount',
            'keterangan',
            'status_aktif',
            'user_created',
            'updated_by'
      ];

      /** Accessor & Mutator */
      public function setDateAttribute($input)
      {
            $this->attributes['date'] = Carbon::parse($input);
      }

      public function getDateAttribute($input)
      {
            return Carbon::parse($input)->translatedFormat(config('app.date_format_frontend'));
      }

      public function detail()
      {
            return $this->hasMany(TransaksiPoDetail::class,'id_transaksi_po','id');
      }

}
