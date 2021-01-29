<?php

namespace App\Model\Transaksi;

use Illuminate\Database\Eloquent\Model;

use App\Scopes\Transaksi\TransaksiScope;

class Transaksi extends Model
{
    const BELUM_CETAK       = 10; 
    const SUDAH_CETAK       = 20;
    
    protected $table        = 'tbl_transaksi';
    protected $guard_name   = 'web';

    public $timestamps = true;

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new TransaksiScope);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'no_resi', 
        'no_pesanan',
        'tgl_pesanan_dibuat',
        'status_pesanan',
        'status_pembatalan',
        'deadline_pengiriman',
        'produk',
        'jasa_kirim',
        'jasa_kirim',
        'username_pembeli',
        'nama_pembeli',
        'telfon_pembeli',
        'alamat_pembeli',
        'kota_pembeli',
        'provinsi_pembeli',
        'kode_pos_pembeli',
        'pendapatan_bersih',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the User.
     */
    public function user()
    {
        return $this->belongsTo('App\Model\User\User');
    }

}
