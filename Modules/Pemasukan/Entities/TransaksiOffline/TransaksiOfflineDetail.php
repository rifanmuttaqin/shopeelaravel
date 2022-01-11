<?php

namespace Modules\Pemasukan\Entities\TransaksiOffline;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiOfflineDetail extends Model
{
    use HasFactory;

    protected $table        = 'tbl_transaksi_offline_detail';
    protected $guard_name   = 'web';

    protected $fillable = [
        'id_transaksi',
        'nama_produk',
        'harga_produk',
        'qty_beli',
        'user_created',
        'updated_by'
    ];
}
