<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

/**
 * Class SettingApiController
 * @package App\Http\Controllers
 */
class CommonApiController extends Controller
{

	private $request;

	public function __construct(Request $request)
    {
    	$this->request = $request;
    }

    /**
     * Valid authenticate
     * Params : [email, password]
     * Method : GET
     * Return : (string) token
     */
    public function token()
    {
        $input = $this->request->all();
        if (!$token = JWTAuth::attempt($input)) {
            return response()->json(['result' => 'Wrong email or password.']);
        }
        return response()->json(['result' => $token]);
    }

	/**
     * import product to Nuvem
     * Params : [token, id]
     * Method : GET
     * Return : (string) result
     */
    public function syncprod()
    {
        $result = app('App\Http\Controllers\IntergrateController')->syncprod($this->request->get('shop_id'));
        return response()->json(['result' => $result]);
    }
}