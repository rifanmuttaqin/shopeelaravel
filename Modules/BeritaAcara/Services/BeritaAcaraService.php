<?php

namespace Modules\BeritaAcara\Services;

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
    public function getAll($search = null)
    {
        return $this->berita_acara->where('tanggal', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC');
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