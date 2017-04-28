<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Log;

use App\Nuvemshop;
use App\Webhook;

class CallbackController extends Controller
{
	public $request;
	public $nuvemShop;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{
		// Get the current request object
		$this->request = $request;

		// Get the nuvemshop object
		$nuvemshop_id = Route::current()->parameter('nuvemShopId');

		$this->nuvemShop = Nuvemshop::findOrFail($nuvemshop_id);
	}
	
	private function log(){
		Log::info($this->request);

		$data = file_get_contents('php://input');
		Log::info($_SERVER);
		Log::info($data);
	}

	/**
	 * Handle event callback when TiendaNube create order
	 * @return [type] [description]
	 */
	public function productCreated() {
		Log::info('TiendaNube Product Created: ');
		$this->log();
	}

	public function productDeleted(){
		Log::info('A product is deleted');
		$this->log();
	}

	/**
	 * Handle event callback when TiendaNube create order
	 * @return [type] [description]
	 */
	public function orderCreated() {

		Log::info('TiendaNube Order Created: ');
		$this->log();
	}
}
