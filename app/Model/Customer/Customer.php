<?php

namespace App\Model\Customer;

use Illuminate\Database\Eloquent\Model;

use App\Scopes\Customer\CustomerScope;

class Customer extends Model
{
    protected $table        = 'tbl_customer';
    protected $guard_name   = 'web';

    public $timestamps      = true;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new CustomerScope);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username_pembeli',
        'username_pembeli',
        'nama_pembeli',
        'telfon_pembeli',
        'alamat_pembeli',
        'kota_pembeli',
        'provinsi_pembeli',
        'kode_pos_pembeli',
        'created_at',
        'updated_at'
    ];

    /**
    * Relation
    */
    public function user()
    {
        $this->belongsTo('App/User/User');
    }

}
