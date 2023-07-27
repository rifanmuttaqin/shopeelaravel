<?php

namespace App\Interfaces;

interface AdvertisementInterface extends BaseInterface
{
    public function getTotal();
    public function getTotalByFilter();
}
