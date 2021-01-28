<?php

namespace App\Services;

use App\Model\Customer\Customer;

use App\Services\TransaksiService;

use Auth;

use Carbon\Carbon;


class CustomerService {

	protected $customer;
    protected $transaksi;

	public function __construct(Customer $customer, TransaksiService $transaksi)
	{
	    $this->customer = $customer;
        $this->transaksi = $transaksi;
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
    * @return static
    */
    public static function sumnewCustomer()
    {
        return Customer::whereMonth('created_at', '=', date('m'))->count();
    }

    public function TotalCustomerByMonth($month=null)
    {
        if($month != null)
        {
            $month = Carbon::parse($month)->month;
        }
        else
        {
            $month = Carbon::now()->month;
        }

        return $this->customer->whereMonth('created_at', '=', $month)->count();
    }


    /**
    * @return int
    */
    public function getByUserName($username)
    {
        return $this->customer->where('username_pembeli', $username)->first();
    }


    /**
    * @return int
    */
    public function sumOrder($customer_id)
    {
        $customer_user_name = $this->customer->findOrfail($customer_id)->username_pembeli;

        if($customer_user_name != null)
        {
            return $this->transaksi->countCustomer($customer_user_name);
        }
        else
        {
            return 0;
        }
    }


    /**
    * @return int
    */
    public function getAll($search = null)
    {
        return $this->customer->where('username_pembeli', 'like', '%'.$search.'%')->get();
    }

}