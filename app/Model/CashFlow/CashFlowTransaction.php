<?php

namespace App\Model\CashFlow;

use App\Scopes\GlobalScopeUSerCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlowTransaction extends Model
{
    use HasFactory;

    protected $table        = 'tbl_cash_flow_transaction';
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
        'cash_flow_camponent_id',
        'type',
        'date',
        'amount',
        'note',
        'user_created',      
        'created_at',
        'updated_at'
    ];

    /**
    * get User
    */
    public function user()
    {
        return $this->belongsTo('App\Model\User\User','user_created','id');
    }

    public function cashFlow()
    {
        return $this->belongsTo('App\Model\CashFlow\CashFlowComponent','cash_flow_camponent_id','id');
    }

}
