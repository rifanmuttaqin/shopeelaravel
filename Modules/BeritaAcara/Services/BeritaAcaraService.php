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

    /**
     * @return
     */
    public function findById($id)
    {
        return $this->berita_acara->findOrFail($id);
    }

}