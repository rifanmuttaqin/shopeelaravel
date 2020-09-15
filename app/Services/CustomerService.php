<?php

namespace App\Services;

use App\Model\Customer\Customer;


class CustomerService {

	protected $customer;

	public function __construct()
	{
	    $this->customer = new Customer();
    }

    /**
    * @return int
    */
    public function checkIfExist($username_pembeli)
    {
    	$data = $this->customer->where('username_pembeli', $username_pembeli)->count();

    	if($data >= 1)
    	{
    		return true; // Benar Exist
    	}

    	return false;
    }

}