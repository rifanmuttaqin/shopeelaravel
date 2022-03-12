<?php

namespace Modules\BeritaAcara\Entities\BeritaAcara;

use App\Scopes\GlobalScopeUSerCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BeritaAcara extends Model
{
    use HasFactory;

    protected $table        = 'tbl_berita_acara';
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
        'tanggal',
        'detail_kejadian',
        'transaksi_id',
        'nominal_kerugian',
        'image_pendukung',
        'status_masalah',
        'status_aktif'
    ];
    
    
}
