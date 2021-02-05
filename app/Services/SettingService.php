<?php

namespace App\Services;

use App\Model\Setting\Setting;

use Auth;

use Illuminate\Http\Request;

class SettingService {

	protected $setting;

	public function __construct(Setting $setting)
	{
	    $this->setting = $setting;
	}

	public function checkIfExist()
	{
		$data = $this->setting->where('user_id', Auth::user()->id)->count();
		return $data >= 1 ? true : false;
	}

	public function getSetting()
	{
		return $this->setting->first();
	}

	public function doUpdate()
	{
		return $this->setting->where('user_id', Auth::user()->id)->update(request()->except('_token'));
	}

	// ------------------- Helper Function ------------------

}