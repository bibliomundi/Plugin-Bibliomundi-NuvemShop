<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Setting;

/**
 * Class SettingController
 * @package App\Http\Controllers
 */
class SettingController extends Controller
{
	public $request;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{
		// $this->middleware('auth');
		$this->request = $request;
	}

	/**
	 * Store new setting
	 * @param type $key 
	 * @param type $value 
	 * @return type
	 */
	public function store($key, $value) 
	{
		// Validate key
		if(!empty($key)) {

			$setting = Setting::firstOrCreate(['key' => $key]);
			$setting->value = $value;
			$setting->save();
			return $setting;
		}

		return null;
	}

	/**
	 * Show the application dashboard.
	 * @return type
	 */
	public function index()
	{	
		$settings = array();
		$setting_models = Setting::get();
		foreach ($setting_models as $model) {
			$settings[$model->key] = $model->value;
		}

		return view('admin.setting', array('setting' => $settings));
	}

	/**
	 * Show the application dashboard.
	 * @return type
	 */
	public function save()
	{
		$inputs = $this->request->except('_token');
		foreach ($inputs as $key => $value) {
			if( !empty($value) ) {
				$this->store($key, $value);
			}
		}

		return redirect()->route('setting.index');
	}
}