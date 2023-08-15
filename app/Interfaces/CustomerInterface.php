<?php

namespace App\Interfaces;

interface CustomerInterface extends BaseInterface
{
    public function sumnewCustomer();
    public function sumOrder($customer_id);
    public function TotalCustomerByMonth($month);
    public function getByUserName($username);
}