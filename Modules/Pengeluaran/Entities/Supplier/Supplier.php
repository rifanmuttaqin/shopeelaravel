<?php

namespace Modules\Pengeluaran\Entities\Supplier;

use App\Scopes\GlobalScopeUSerCreated;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
      use HasFactory;

      protected $table        = 'tbl_supplier';
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
            'nama',
            'kontak',
            'alamat',
            'keterangan',
            'status_aktif',
            'created_by',
            'updated_by'
      ];

}
