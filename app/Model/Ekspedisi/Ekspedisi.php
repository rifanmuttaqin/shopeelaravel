<?php

namespace App\Model\Ekspedisi;

use Illuminate\Database\Eloquent\Model;

use App\Scopes\GlobalScopeUSerCreated;

class Ekspedisi extends Model
{
    protected $table        = 'tbl_ekspedisi';
    protected $guard_name   = 'web';

    public $timestamps      = true;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
      static::addGlobalScope(new GlobalScopeUSerCreated);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_created',
        'ekspedisi_name',
        'ekspedisi_kode',
        'ekspedisi_kurir_pickup',
        'ekspedisi_kurir_number',
        'ekspedisi_kurir_number',
        'ekspedisi_droppoint_address',
        'created_at',
        'updated_at'
    ];

    /**
    * get User
    */
    public function user()
    {
        return $this->belongsTo('App\User\User','user_created','id');
    }

}
