<?php

namespace Modules\Pemasukan\Services;

use Modules\Pemasukan\Entities\CustomerOffline\CustomerOffline;

class CustomerOfflineService {

    protected $customer;

    public function __construct(CustomerOffline $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return
     */
    public function getByProductName($param)
    {
        return $this->customer->where('nama', $param)->first();
    }

    /**
     * @return
     */
    public function getAll($search = null)
    {
        return $this->customer->where('nama', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC');
    }

    /**
     * @return
     */
    public function findById($id)
    {
        return $this->customer->findOrFail($id);
    }

}