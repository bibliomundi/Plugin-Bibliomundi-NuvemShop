<?php

namespace App\Http\Controllers\Callback;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Mail\ProductDownload;
use Illuminate\Support\Facades\Mail;

use Log;

use App\Nuvemshop;
use App\Webhook;
use App\Product;
use App\Productmapping;
use App\Bibliomundi;

use TiendaNube;

class OrderController extends Controller
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
	public function created()
	{
		Log::info('An Order has been created.');
		
		// Response to test
		return response()->json(['message' => 'Webhook Order/created OK'], 200);
	}

	/**
	 * Function to handle callback from TiendaNube when a product updated
	 * @return [type] [description]
	 */
	public function updated() {
	}

	/**
	 * Function to handle callback from TiendaNube when a product paid
	 * @return [type] [description]
	 */
	public function paid() {
		Log::info('The customer has paid for the order.');

		$store_id = $this->request->store_id;
		$event = $this->request->event;
		$orderId = $this->request->id;

		// Get nuvem shop from DB
		$nuvemShop = Nuvemshop::where('tiendanube_id', '=', $store_id)->first();
		if(empty($nuvemShop)) {
			return response()->json(['message' => __('callback.store_not_found')], 404);
		}

		// Check the event name
		if($event != 'order/paid') {
			return response()->json(['message' => __('callback.event_must_be_order_paid')], 400);
		}

		// Check Order
		$api = new \TiendaNube\API($nuvemShop->tiendanube_id, $nuvemShop->access_token, 'Bibliomundi');
		$tiendaResponse = $api->get("orders/" . $orderId);
		if( !($tiendaResponse instanceof \TiendaNube\API\Response) || $tiendaResponse->status_code != 200 || empty($tiendaResponse->body)) {
			return response()->json(['message' => __('callback.order_not_existed')], 404);
		}

		// Get order info
		$tiendaOrder = $tiendaResponse->body;

		// Get needed customer info
		$tiendaCustomer = $tiendaOrder->customer;
		$biblioCustomer = array(
			'customerIdentificationNumber'	=> $tiendaCustomer->id,			// INT, YOUR STORE CUSTOMER ID
			'customerFullname'				=> $tiendaCustomer->name,		// STRING, CUSTOMER FULL NAME
			'customerEmail'					=> $tiendaCustomer->email,		// STRING, CUSTOMER EMAIL
			'customerGender'				=> 'm',							// (hardcode) ENUM, CUSTOMER GENDER, USE m OR f (LOWERCASE!! male or female)
			'customerBirthday'				=> date('Y/m/d'),				// (hardcode) STRING, CUSTOMER BIRTH DATE, USE Y/m/d (XXXX/XX/XX)
			'customerCountry'				=> $tiendaCustomer->default_address->country,	// STRING, 2 CHAR STRING THAT INDICATE THE CUSTOMER COUNTRY (BR, US, ES, etc)
			'customerZipcode'				=> $tiendaCustomer->default_address->zipcode,	// STRING, POSTAL CODE, ONLY NUMBERS
			'customerState'					=> 'RJ'							// STRING, 2 CHAR STRING THAT INDICATE THE CUSTOMER STATE (RJ, SP, NY, etc)
		);

		// Get products
		$tiendaProducts = $tiendaOrder->products;
		if(empty($tiendaProducts)) {
			return response()->json(['message' => __('callback.order_is_empty')], 400);
		}

		$biblioProducts = array();
		$errorMessage = '';
		
		foreach ($tiendaProducts as $product) {
			$productMapping = Productmapping::where('nuvem_id_product', '=', $product->product_id)->first();
			if(!empty($productMapping)) {
				$biblioProducts[] = array(	'id'		=> $productMapping->bbm_id_product,
											'price'		=> $product->price,
											'currency'	=> 'BRL');	// (hardcode) $tiendaOrder->currency
			}
			else {
				$errorMessage = __('callback.product_id_is_not_existed');
			}
		}

		// Validate products list
		if(empty($biblioProducts)) {
			return response()->json(['message' => $errorMessage], 500);
		}

		// Everything OK, purchase on BilioMundi
		$order = array(
			'id' => $tiendaOrder->id,
			'customer' => $biblioCustomer,
			'products' => $biblioProducts,
		);

		$bbm = new Bibliomundi();
		$purchase = $bbm->purchase($order);

		if($purchase->code == 201) {
			//TODO: Email to client
			
			// Get download link
			$downloadLinks = array();

			foreach ($biblioProducts as $product) {
				$downloadLinks[] = route('download.product', ['orderId' => $order['id'], 'productId' => $product['id']]);
			}

			// Get mail info
			$emailTo = $biblioCustomer['customerEmail'];

			// Set info to send to mailable object
			$params = array(
				'recipientName' => $biblioCustomer['customerFullname'],
				'downloadLinks' => $downloadLinks
			);

			Mail::to($emailTo)->send(new ProductDownload($nuvemShop, $params));

			return $downloadLinks;
		}
		else {
			throw new Exception($purchase->message, $purchase->code);
		}

		// Response to test
		return response()->json(['message' => 'Webhook Order/paid OK'], 200);
	}

	/**
	 * Function to handle callback from TiendaNube when a product fulfilled
	 * @return [type] [description]
	 */
	public function fulfilled() {
	}

	/**
	 * Function to handle callback from TiendaNube when a product cancelled
	 * @return [type] [description]
	 */
	public function cancelled() {
	}

	/**
	 * Function to list orders from TiendaNube - only for test
	 * @return [type] [description]
	 */
	public function getList() {

		$store_id = $this->request->store_id;

		// Get nuvem shop from DB
		$nuvemShop = Nuvemshop::where('tiendanube_id', '=', $store_id)->first();
		if(empty($nuvemShop)) {
			return response()->json(['message' => __('callback.store_not_found')], 404);
		}

		// Check Order
		$api = new \TiendaNube\API($nuvemShop->tiendanube_id, $nuvemShop->access_token, 'Bibliomundi');
		$tiendaResponse = $api->get("orders");

		return response()->json($tiendaResponse, 200);
	}
}
