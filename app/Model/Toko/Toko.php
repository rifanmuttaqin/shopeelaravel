<?php

namespace App\Model\Toko;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    protected $table        = 'tbl_user_toko';
    protected $guard_name   = 'web';

    public $timestamps      = true;

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

}
