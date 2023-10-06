<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface BaseInterface
{
    public function findById($attribute);
    public function getAll($search=null);
}

