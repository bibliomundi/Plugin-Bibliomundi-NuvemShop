<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;

/**
 * Class SettingApiController
 * @package App\Http\Controllers
 */
class SettingApiController extends Controller
{

	private $request;

	public function __construct(Request $request)
    {
    	$this->request = $request;
    }

	/**
     * get setting
     * Params : [token, {key}]
     * Method : GET
     * Return : (array) setting
     */
    public function index()
    {
        $input = $this->request->all();
        if(isset($input['key'])) {
            return response()->json(['result' => Setting::where('key', $input['key'])->get()]);
        } else {
            return response()->json(['result' => Setting::get()]);
        }
    }
    
    public function create()
    {
    	
    }

    /**
     * save setting
     * Params : [token, {key}, {value}]
     * Method : POST
     * Return : (string) result
     */
    public function store()
    {
    	$input = $this->request->all();
        if(empty($input['key']) || empty($input['value'])) {
            return response()->json(['result' => 'Missing key or value.']);
        } else {
            // create or update
            $setting = Setting::firstOrCreate(['key' => $input['key']]);
            $setting->value = $input['value'];
            $setting->save();
            return response()->json(['result' => 'Save setting successful.']);
        }
    }

    public function show()
    {
    	//same behavior with index
    }

    public function edit()
    {
    	
    }

    public function update()
    {
    	
    }

    public function destroy()
    {
    	
    }
}