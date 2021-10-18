<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Model\Setting\Setting;
use App\Services\SettingService;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
 	public $setting;

	/**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct(SettingService $setting)
	{
	  $this->middleware('auth');
	  $this->setting = $setting;
	}   


	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request)
	{
		$data_user_setting = $this->setting->getSetting();
		return view('system-setting.index', ['active'=>'system-setting', 'title'=> 'Pengaturan Umum Pengguna', 'data_user_setting' => $data_user_setting]);
	}

	public function update(UpdateSettingRequest $request)
	{
		DB::beginTransaction();

		if($this->setting->checkIfExist())
		{
			$setting_model = $this->setting->doUpdate();
			
			if($setting_model)
			{
				DB::commit();
				return redirect('setting')->with('alert_success', 'Berhasil Disimpan'); 
			}
		}
		else
		{
			$setting_model  = new Setting($request->all());

			if($setting_model->save())
			{
				DB::commit();
				return redirect('setting')->with('alert_success', 'Berhasil Disimpan'); 
			}
		}
		
		DB::rollBack();
		return redirect('setting')->with('alert_error', 'Gagal Disimpan');		
	}
}
