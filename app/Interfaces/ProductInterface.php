<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function getAll($search=null);
    public function findById($id);
}
