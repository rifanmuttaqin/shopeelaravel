<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\User\PasswordRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\StoreUserRequest;

use Yajra\Datatables\Datatables;

use App\Model\User\User;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserCollection;

use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Maatwebsite\Excel\Facades\Excel;

use Auth;

use DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) 
        {
            $data = User::getUser();
           
            return Datatables::of($data)
                    ->addColumn('account_type', function($row){  
                        $data = User::getAccountMeaning($row->account_type);
                        return $data; 
                    })
                    ->addColumn('action', function($row){  
                        $btn = '<button onclick="btnUbah('.$row->id.')" name="btnUbah" type="button" class="btn btn-info"><i class="far fa-edit"></i></button>';
                        $pass = '<button onclick="btnPass('.$row->id.')" name="btnPass" type="button" class="btn btn-info"><i class="fas fa-lock"></i></button>';
                        $delete = '<button onclick="btnDel('.$row->id.')" name="btnDel" type="button" class="btn btn-info"><i class="fas fa-trash"></i></button>';
                        return $btn .'&nbsp'. $pass .'&nbsp'. $delete; 
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('user.index', ['active'=>'user', 'title'=> 'Daftar Pengguna']);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.store', ['active'=>'user', 'title'=>'Pengelolaan User']);
    }

    /**
     * 
     * Validasi ID PS User PS
     * @return 
     * */
    private function validateUser($param)
    {
        $status = true;

        if($param->get('account_type') == User::ACCOUNT_TYPE_PS)
        {
            $id_user = $param->get('id_ps');
        }
        else if($param->get('account_type') == User::ACCOUNT_TYPE_KOSEKA)
        {
            $id_user = $param->get('id_ptl');
        }
        else
        {
            return $status;
        }
        
        $kode_prov  = substr($id_user,0,2);
        $kode_kab   = substr($id_user,2,2);
        $kode_kec   = substr($id_user,4,3);
        
        if($kode_prov != Provinsi::findOrFail($param->provinsi_id)->kode_provinsi)
        {
            $status = false;
        }
        
        if($kode_kab != Kabupaten::findOrFail($param->kabupaten_id)->kode_kabupaten)
        {
            $status = false;
        }

        if($kode_kec != Kecamatan::findOrFail($param->kecamatan_id)->kode_kecamatan)
        {
            $status = false;
        } 
                       
        return $status;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {        
        DB::beginTransaction();        
        $user = new User();

        $user->nik              = $request->get('nik');
        $user->nama             = $request->get('nama');
        $user->nomor_hp         = $request->get('nomor_hp');
        $user->password         = $request->get('nik');
        $user->account_type     = $request->get('account_type');
        $user->provinsi_id      = $request->get('provinsi_id');
        $user->kabupaten_id     = $request->get('kabupaten_id');
        $user->email            = $request->get('email');
        $user->status_transaksi_spss   = User::USER_BELUM_PARTISIPASI;
        $user->status           = User::USER_STATUS_ACTIVE;
                    
        if(!$user->save())
        {
            DB::rollBack();
            return redirect('user')->with('alert_error', 'Gagal Disimpan');
        }
                    
        // $user->assignRole(User::getAccountMeaning($user->account_type));
        DB::commit();
        return redirect('user')->with('alert_success', 'Berhasil Disimpan');
        
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {

            if($request->iduser != null)
            {
                $user_id    = $request->iduser;
                $userModel  = User::findOrFail($user_id);

                return new UserResource($userModel);
            }
            else
            {
                return $this->getResponse(false,500,'','Akses gagal dilakukan');
            }
        }
    }

    /**
     *
     *
     * @param  \App\Model\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    { 
        return view('user.import', ['active'=>'user-import', 'title'=> 'Import User']); 
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        if ($request->ajax()) {
            
            DB::beginTransaction();
            $user = User::findOrFail($request->iduser);

            $user->nik              = $request->get('nik');
            $user->nama             = $request->get('nama');
            $user->nomor_hp         = $request->get('nomor_hp');
            $user->account_type     = $request->get('account_type');
            $user->provinsi_id      = $request->get('provinsi_id');
            $user->kabupaten_id     = $request->get('kabupaten_id');
            $user->email            = $request->get('email');
            $user->status_transaksi_spss   = $user->status_transaksi_spss;

            $user_backup            = $user;
            
            if(!$user->save())
            {
                DB::rollBack();
                return $this->getResponse(false,400,null,'User gagal diupdate');
            }
                    
            DB::commit();
            return $this->getResponse(true,200,'','User berhasil diupdate');
            
        }
    }

    /**
     * @return void
     */
    public function updatePassword(PasswordRequest $request)
    {
        if ($request->ajax()) 
        {
            DB::beginTransaction();

            $user = User::findOrFail($request->iduser);
            $user->password = $request->password;

            if(!$user->save())
            {
                DB::rollBack();
                return $this->getResponse(false,400,null,'Password gagal diupdate');
            }

            DB::commit();
            return $this->getResponse(true,200,'','Password berhasil diupdate');   
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\User\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {        
        if ($request->ajax()) 
        {
            DB::beginTransaction();

            $user = User::find($request->iduser);

            $user_login = $this->getUserLogin()->id;

            if($user->id == $user_login)
            {
                DB::rollBack();
                return $this->getResponse(false,400,null,'User Aktif Gagal Terhapus');
            }
            else
            {
                if(!$user->delete())
                {
                    DB::rollBack();
                    return $this->getResponse(false,400,null,'User Gagal Dihapus');
                }

                DB::commit();
                return $this->getResponse(true,200,'','User Berhasil Dihapus');  
            }   
        }
    }
}
