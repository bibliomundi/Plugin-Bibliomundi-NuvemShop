<?php

namespace App\Http\Controllers\Callback;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Log;

use App\Nuvemshop;
use App\Webhook;
use App\Productmapping;

class ProductController extends Controller
{
    public $request;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(Request $request)
	{
		// Get the current request object
		$this->request = $request;
		
		Log::info($this->request->all());
	}

	/**
	 * Function to handle callback from TiendaNube when a product created
	 * @return [type] [description]
	 */
	public function created() {
		Log::info('An Product has been created.');
	}

	/**
	 * Function to handle callback from TiendaNube when a product updated
	 * @return [type] [description]
	 */
	public function updated() {
	}

	/**
	 * Function to handle callback from TiendaNube when a product deleted
	 * @return [type] [description]
	 */
	public function deleted() {

		// Get params
		$store_id = $this->request->store_id;
		$event = $this->request->event;
		$productId = $this->request->id;

		// Get nuvem shop from DB
		$nuvemShop = Nuvemshop::where('tiendanube_id', '=', $store_id)->first();
		if(empty($nuvemShop)) {
			return response()->json(['message' => __('callback.store_not_found')], 404);
		}

		// Check the event name
		if($event != 'product/deleted') {
			return response()->json(['message' => __('callback.event_must_be_product_deleted')], 400);
		}

		Log::info('TiendaNube: Product deleted. ID = ' . $productId);

		// Delete Product Mapping
		Productmapping::where('nuvem_id_product', '=', $productId)->delete();
	}
}
