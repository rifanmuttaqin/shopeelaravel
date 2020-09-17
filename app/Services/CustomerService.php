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

    /**
    * @return int
    */
    public static function sumOrder($customer_id)
    {
        $customer_user_name = Customer::findOrfail($customer_id)->username_pembeli;

        if($customer_user_name != null)
        {
            return TransaksiService::countCustomer($customer_user_name);
        }
        else
        {
            return 0;
        }
    }


    /**
    * @return int
    */
    public static function getAll()
    {
        $data = Customer::get();
        return $data;
    }

}