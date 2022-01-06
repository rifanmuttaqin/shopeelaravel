<?php

namespace Modules\Pemasukan\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Pemasukan\Entities\CustomerOffline\CustomerOffline;
use Modules\Pemasukan\Http\Requests\CustomerOffline\StoreCustomerOfflineRequest;
use Modules\Pemasukan\Http\Requests\CustomerOffline\UpdateCustomerOfflineRequest;
use Modules\Pemasukan\Services\CustomerOfflineService;
use Yajra\Datatables\Datatables;


class CustomerOfflineController extends Controller
{
    private $customer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerOfflineService $customer)
    {
        $this->middleware('auth');
        $this->customer = $customer;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = $this->customer->getAll();

            return Datatables::of($data)
            ->addColumn('action', function($row){  
                return $this->getActionColumn($row);
            })->make(true);
        }

        return view('pemasukan::customer.index',['active'=>'customer-offline', 'title'=> 'Daftar Pelanggan Offline']);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('pemasukan::customer.create',['active'=>'customer-offline', 'title'=> 'Penambahan Pelanggan Offline']);
    }

    public function store(StoreCustomerOfflineRequest $request)
    {
        DB::beginTransaction();

        $model = new CustomerOffline($request->all());
        
        if(!$model->save())
        {
            DB::rollBack();
            return redirect('pemasukan/customer')->with('alert_error', 'Gagal Disimpan');
        }

        DB::commit();
        return redirect('pemasukan/customer')->with('alert_success', 'Berhasil Disimpan');
    }

    public function edit($id=null)
    {
        if($id != null)
        {
            $data_customer = $this->customer->findById($id);
            return view('pemasukan::customer.edit',['active'=>'customer-offline', 'title'=> 'Update Pelanggan Offline '.$data_customer->nama,'data_customer'=>$data_customer]);
        }
    }

    public function update(UpdateCustomerOfflineRequest $request)
    {
        DB::beginTransaction();

        $model = CustomerOffline::findOrFail($request->id)->update($request->all());

        if($model)
        {
            DB::commit();
            return redirect('pemasukan/customer')->with('alert_success', 'Berhasil Disimpan'); 
        }

        DB::rollBack();
        return redirect('pemasukan/customer')->with('alert_error', 'Gagal Simpan');
    }

    public function show($id=null)
    {
        if($id != null)
        {
            $data_customer = $this->customer->findById($id);
            return view('pemasukan::customer.show',['active'=>'customer-offline', 'title'=> 'Detail Pelanggan Offline '.$data_customer->nama,'data_customer'=>$data_customer]);
        }
    }

    public function delete($id=null)
    {
        if($id != null)
        {
            $data_customer = $this->customer->findById($id);
            return view('pemasukan::customer.delete',['active'=>'customer-offline', 'title'=> 'Hapus Pelanggan Offline '.$data_customer->nama,'data_customer'=>$data_customer]);
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        $model = CustomerOffline::findOrFail($request->id)->delete();

        if($model)
        {
            DB::commit();
            return redirect('pemasukan/customer')->with('alert_success', 'Berhasil Dihapus'); 
        }

        DB::rollBack();
        return redirect('pemasukan/customer')->with('alert_error', 'Gagal Dihapus');
    }


    /**
     * List Customer
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if($request->ajax())
        {
            $data_customer = null;
            $data_customer = $this->customer->getAll($request->get('search'));
            
            $arr_data      = array();

            if($data_customer != null)
            {
                $key = 0;

                foreach ($data_customer->get() as $data) 
                {
                    $arr_data[$key]['id']   = $data->id;
                    $arr_data[$key]['text'] = $data->username_pembeli;
                    $key++;
                }
            }

            return json_encode($arr_data);
        }
    }
    
    // --------------- HELPER FUNCTION --------------

    /**
     * @param $data
     * @return string
     */
    protected function getActionColumn($data): string
    {
        $showUrl    = route('customer-offline-show', $data->id);
        $editUrl    = route('customer-offline-edit', $data->id);
        $deleteUrl  = route('customer-offline-delete', $data->id);
        
        return  "<a class='btn btn-info' data-value='$data->id' href='$showUrl'><i class='far fa-eye'></i></a> 
        <a class='btn btn-info' data-value='$data->id' href='$editUrl'><i class='far fa-edit'></i></a>
        <a class='btn btn-info' data-value='$data->id' href='$deleteUrl'><i class='fas fa-trash'></i></a>";
    }

}
