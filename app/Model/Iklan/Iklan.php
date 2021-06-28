<?php

namespace App\Model\Iklan;

use Illuminate\Database\Eloquent\Model;

use App\Scopes\GlobalScopeUSerCreated;

class Iklan extends Model
{
    protected $table        = 'tbl_topup_iklan';
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
        'user_toko_id',
        'total_iklan',
        'date',
        'created_at',
        'updated_at'
    ];

    /**
    * Relation
    */
    public function user()
    {
        $this->belongsTo('App\User\User');
    }

}
