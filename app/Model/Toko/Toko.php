<?php

namespace App\Model\Toko;

use Illuminate\Database\Eloquent\Model;

use App\Scopes\Toko\TokoScope;

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

        static::addGlobalScope(new TokoScope);
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
        return $this->belongsTo('App\User\User');
    }

    public function transaksi()
    {
        return $this->hasMany('App\Transaksi\Transaksi');
    }

}
