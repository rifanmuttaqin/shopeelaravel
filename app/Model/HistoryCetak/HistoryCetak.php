<?php

namespace App\Model\HistoryCetak;

use Illuminate\Database\Eloquent\Model;

use App\Scopes\Cetak\HistoryCetakScope;

class HistoryCetak extends Model
{
    protected $table        = 'tbl_history_cetak';
    protected $guard_name   = 'web';

    public $timestamps      = true;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new HistoryCetakScope);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_created',
        'date_range',
        'user_toko_id',
        'array_user',
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

    /**
    * get Toko
    */
    public function toko()
    {
        return $this->belongsTo('App\Model\Toko\Toko','user_toko_id', 'id');
    }

}
