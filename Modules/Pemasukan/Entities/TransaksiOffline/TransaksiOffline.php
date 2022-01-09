<?php

namespace Modules\Pemasukan\Entities\TransaksiOffline;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiOffline extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_customer',
        'total_amount',
        'discount_amount',
        'status_transaksi',
        'user_created',
        'updated_by'
    ];
    
    
    
}
