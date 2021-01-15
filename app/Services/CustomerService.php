<?php

namespace App\Services;

use App\Model\Customer\Customer;

use Auth;


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
    	$data = $this->customer->where('username_pembeli', $username_pembeli)->where('user_created', Auth::user()->id)->count();

    	if($data >= 1)
    	{
    		return true; // Benar Exist
    	}

    	return false;
    }

    /**
    * @return int
    */
    public static function sumnewCustomer()
    {
        return Customer::whereMonth('created_at', '=', date('m'))->where('user_created', Auth::user()->id)->count();
    }


    /**
    * @return int
    */
    public static function getByUserName($username)
    {
        return Customer::where('username_pembeli', $username_pembeli)->first();
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
    public static function getAll($search = null)
    {
        $data = Customer::where('username_pembeli', 'like', '%'.$search.'%')->where('user_created', Auth::user()->id)->where('user_created', Auth::user()->id)->get();
        return $data;
    }

}