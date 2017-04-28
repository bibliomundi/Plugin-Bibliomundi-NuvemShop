<?php

namespace App\Http\Controllers\Download;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Log;

use App\Nuvemshop;
use App\Webhook;
use App\Product;
use App\Productmapping;
use App\Bibliomundi;

use TiendaNube;

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
	}

	/**
	 * Function to download product
	 * @param  [type] $orderId   [description]
	 * @param  [type] $productId [description]
	 * @return [type]            [description]
	 */
	public function download($orderId, $productId)
	{
		$bbm = new Bibliomundi();
		$bbm->download($orderId, $productId);
	}
}
