<?php

namespace Modules\BeritaAcara\Services;

use Carbon\Carbon;
use Modules\BeritaAcara\Entities\BeritaAcara\BeritaAcara;

class BeritaAcaraService {

    protected $berita_acara;

    public function __construct(BeritaAcara $berita_acara)
    {
        $this->berita_acara = $berita_acara;
    }

    /**
     * @return
     */
    public function getAll($search = null, $date_start=null, $date_end=null, $status_masalah=null, $transaksi=null)
    {
        $data = $this->berita_acara;

        if($date_start != null && $date_end != null){
            
            $date_from  = Carbon::parse($date_start)->startOfDay();
            $date_to    = Carbon::parse($date_end)->endOfDay();

            $data->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        }

        if($status_masalah != null){
            $data->where('status_masalah', $status_masalah);
        }
        
        if($transaksi != null){
            $data->where('transaksi_id', $transaksi);
        }
        
        
        return $data->where('tanggal', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC');
    }

    public function getReadmore($row=null)
    {
        if($row != null){
            return substr($row->detail_kejadian, 0, 40);
        }
    }


    /**
     * @return
     */
    public function findById($id)
    {
        return $this->berita_acara->findOrFail($id);
    }

    public function statusMasalahMeaning($param){
        switch ($param) {
            case '10':
                return 'AKTIF';
            case '20':
                return 'PENDING';
            case '30':
                return 'SELESAI';
            default:
               return 'TIDAK DIKETAHUI';
        }
    }
}