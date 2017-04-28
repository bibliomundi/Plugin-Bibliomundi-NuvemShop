<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Nuvemshop;

/**
 * Class SettingApiController
 * @package App\Http\Controllers
 */
class NuvemshopApiController extends Controller
{

	private $request;

	public function __construct(Request $request)
    {
    	$this->request = $request;
    }

	/**
     * get shops
     * Params : [token]
     * Method : GET
     * Return : (array) shop
     */
    public function index()
    {
        return response()->json(['result' => Nuvemshop::get()]);
    }
    
    public function create()
    {
    	
    }

    /**
     * create shop
     * Params : [token, {client_id}, {client_secret}]
     * Method : POST
     * Return : (string) result
     */
    public function store()
    {
    	$input = $this->request->all();
        if(empty($input['client_id']) || empty($input['client_secret'])) {
            return response()->json(['result' => 'Missing client id or client secret.']);
        } else {
            // create
            if (Nuvemshop::where('client_id', '=', $input['client_id'])->exists()) {
                return response()->json(['result' => 'Client ID has already exists.']);
            }
            Nuvemshop::insert(['client_id' => $input['client_id'], 'client_secret' => $input['client_secret']]);                
            return response()->json(['result' => 'Create shop successful.']);
        }
    }

    /**
     * get shop
     * Params : [token, id]
     * Method : GET
     * Return : shop
     */
    public function show($id)
    {   
        if($nuvemshop = Nuvemshop::find($id)){
            return response()->json(['result' => $nuvemshop]);
        }else{
            return response()->json(['result' => 'ID not found.']);
        }
    }

    public function edit()
    {
    	
    }

    /**
     * update shop
     * Params : [token, id, {client_id}, {client_secret}]
     * Method : PUT/PATCH
     * Return : (string) result
     */
    public function update($id)
    {            
        if($nuvemshop = Nuvemshop::find($id)){
            $input = $this->request->all();
            if(isset($input['client_id'])){
                if (Nuvemshop::where('client_id', '=', $input['client_id'])->where('id', '!=', $id)->exists()) {
                    return response()->json(['result' => 'Client ID has already exists.']);
                }else{
                    $nuvemshop->client_id = $input['client_id'];
                }
            }
            if(isset($input['client_secret'])){
                $nuvemshop->client_secret = $input['client_secret'];
            }
            $nuvemshop->save();
            return response()->json(['result' => 'Update shop successful.']);
        }else{
            return response()->json(['result' => 'ID not found.']);
        }
    }

    /**
     * delete shop
     * Params : [token, id]
     * Method : DELETE
     * Return : (string) result
     */
    public function destroy($id)
    {
        if($nuvemshop = Nuvemshop::find($id)){
            $nuvemshop->delete();
            return response()->json(['result' => 'Delete shop successful.']);
        }else{
            return response()->json(['result' => 'ID not found.']);
        }    	
    }
}