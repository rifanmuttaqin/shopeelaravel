<?php

namespace Modules\Pemasukan\Entities\TransaksiOffline;

use App\Scopes\GlobalScopeUSerCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiOffline extends Model
{
    const STATUS_LUNAS = 10;
    const STATUS_BELUM_LUNAS = 20;

    use HasFactory;

    protected $table        = 'tbl_transaksi_offline';
    protected $guard_name   = 'web';

    public $timestamps      = true;

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new GlobalScopeUSerCreated);

        static::deleting(function($var) {
                
                $relationMethods = [];

                foreach ($relationMethods as $relationMethod) {
                    if ($var->$relationMethod()->count() > 0) 
                    {
                        return false;
                    }
                }
        });
    }

    protected $fillable = [
        'nama_customer',
        'total_amount',
        'discount_amount',
        'status_transaksi',
        'invoice_code',
        'keterangan',
        'user_created',
        'date',
        'updated_by',
        'status_aktif'
    ];

    /** Accessor & Mutator */
    public function setDateAttribute($input)
    {
        $this->attributes['date'] = Carbon::parse($input);
    }

    public function getDateAttribute($input)
    {
        return Carbon::parse($input)->translatedFormat(config('app.date_format_frontend'));
    }

    public static function defineStatus($param)
    {
        switch ($param) {
            case '10':
               return 'Lunas';
            case '20':
                return 'Belum Lunas';
            default:
                return 'Tidak diketahui';
        }
    }
    
    
    
}
