<?php

namespace App\Model\Toko;

use App\Scopes\GlobalScopeUserId;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    protected $table        = 'tbl_user_toko';
    protected $guard_name   = 'web';

    public $timestamps      = true;

    /**
     *
     */
    protected static function boot()
    {
            parent::boot();

            static::addGlobalScope(new GlobalScopeUserId);

            static::deleting(function($var) {
                  
                  $relationMethods = ['transaksi'];

                  foreach ($relationMethods as $relationMethod) {
                        if ($var->$relationMethod()->count() > 0) 
                        {
                              return false;
                        }
                  }
            });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nama_toko',
        'alamat_toko',
        'link_shopee'
    ];


    public function user()
    {
        return $this->belongsTo('App\Model\User\User');
    }

    public function transaksi()
    {
        return $this->hasMany('App\Model\Transaksi\Transaksi','user_toko_id');
    }

}
