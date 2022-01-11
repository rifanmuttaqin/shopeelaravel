<?php

namespace Modules\Pemasukan\Entities\TransaksiOffline;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiOffline extends Model
{
    use HasFactory;

    protected $table        = 'tbl_transaksi_offline';
    protected $guard_name   = 'web';

    protected $fillable = [
        'nama_customer',
        'total_amount',
        'discount_amount',
        'status_transaksi',
        'invoice_code',
        'user_created',
        'updated_by'
    ];
    
    
    
}
