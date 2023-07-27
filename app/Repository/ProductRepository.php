<?php

namespace App\Repository;

use App\Interfaces\ProductInterface;
use App\Model\Produk\Produk;

class ProductRepository implements ProductInterface
{
    private $model;

    public function __construct(Produk $product)
    {
        $this->model   = $product;
    }

    public function getAll($search=null)
    {
        return $this->model->where('nama_produk', 'like', '%'.$search.'%')->orderBy('created_at', 'DESC');
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }


}