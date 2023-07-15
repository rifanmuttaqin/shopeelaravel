<?php

namespace App\Repository;

use App\Interfaces\ProductInterface;
use App\Model\Produk\Produk;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductRepository implements ProductInterface
{
    private $model;

    public function __construct(Produk $product)
    {
        $this->model   = $product;
    }

    public function getAll()
    {
        $data = $this->model->orderBy('created_at', 'DESC');

        return $data;
    }


}