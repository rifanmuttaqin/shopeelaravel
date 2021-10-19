<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Services\TransaksiService;
use Illuminate\Http\Request;


class HomeController extends Controller
{
      private $transaksi_service;
      private $customer_service;

      public function __construct(TransaksiService $transaksi_service, CustomerService $customer_service)
      {
            $this->transaksi_service = $transaksi_service;
            $this->customer_service = $customer_service;
            $this->middleware('auth');
      }

      /**
       * Show the application dashboard.
       *
       * @return \Illuminate\Contracts\Support\Renderable
       */
      public function index(Request $request)
      {
            return view('home.index', ['active'=>'home', 'title'=>'Dashboard','transaksi_service'=>$this->transaksi_service,'customer_service'=>$this->customer_service]);   
      }
}
