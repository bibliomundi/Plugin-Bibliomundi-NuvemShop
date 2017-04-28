<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Nuvemshop;
use App\Webhook;

use TiendaNube;

class WebhookController extends Controller
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

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// Retrieve all webhooks of the nuvemshop
		$webhooks = $this->nuvemShop->webhooks;

		return view('admin.webhook.index', array('nuvemShop' => $this->nuvemShop,
												'webhooks' => $webhooks));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.webhook.form', array('nuvemShop' => $this->nuvemShop));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store()
	{
		// Get params
		$params = $this->request->only('event', 'url');

		// Add  other needed params
		$params['nuvemshop_id'] = $this->nuvemShop->id;
		$params['status'] = config('constants.WEBHOOK_STATUS_PENDING');

		// Create new model and save to DB
		$webhook = Webhook::create($params);

		/*
		 * Call API to TiendaNube
		 */
		$data = array(
			'event' => $webhook->event,
			'url'   => $webhook->url);

		$api = new \TiendaNube\API($this->nuvemShop->tiendanube_id, $this->nuvemShop->access_token, 'Bibliomundi');
		$response = $api->post("webhooks", $data);

		if($response instanceof \TiendaNube\API\Response){
			if($response->status_code == 201) {

				// Update Status to the webhook
				$webhook->update(array('status' => config('constants.WEBHOOK_STATUS_ACTIVE'),
										'tienda_id' => $response->body->id));			

				// Set notice
				Session::flash('alert', __('webhook.sync_success'));
				Session::flash('alert_class','alert-info');
				
				return redirect()->route('webhooks.index', array('nuvemShopId' => $this->nuvemShop->id));
			}	
		}
		
		// Set notice
		Session::flash('alert', __('webhook.sync_fail'));
		Session::flash('alert_class','alert-warning');

		//Redirect to list webhooks page
		return redirect()->route('webhooks.index', array('nuvemShopId' => $this->nuvemShop->id));
	}

	/**
	 * Display the specified resource.
	 * @param  [type] $nuvemshopId [description]
	 * @param  [type] $webhookId   [description]
	 * @return [type]              [description]
	 */
	public function show($nuvemShopId, $webhookId)
	{
		// Get the webhook
		$webhook = Webhook::findOrFail($webhookId);

		// Return to edit view
		return view('admin.webhook.form', array('nuvemShop' => $this->nuvemShop,
												'webhook' => $webhook));
	}

	/**
	 * Show the form for editing the specified resource.
	 * @param  [type] $nuvemshopId [description]
	 * @param  [type] $webhookId   [description]
	 * @return [type]              [description]
	 */
	public function edit($nuvemShopId, $webhookId)
	{
		// Get the webhook
		$webhook = Webhook::findOrFail($webhookId);

		return view('admin.webhook.form', array('nuvemShop' => $this->nuvemShop,
												'webhook' => $webhook));
	}

	/**
	 * Update the specified resource in storage.
	 * @param  [type] $nuvemShopId [description]
	 * @param  [type] $webhookId   [description]
	 * @return [type]              [description]
	 */
	public function update($nuvemShopId, $webhookId)
	{
		// Get the webhook
		$webhook = Webhook::findOrFail($webhookId);

		// Get params
		$params = $this->request->only('event', 'url');

		$params['nuvemshop_id'] = $this->nuvemShop->id;

		// Update to DB
		$webhook->update($params);

		if(!empty($webhook->tienda_id)) {
			$data = array(
				'event' => $webhook->event,
				'url'   => $webhook->url);

			$api = new \TiendaNube\API($this->nuvemShop->tiendanube_id, $this->nuvemShop->access_token, 'Bibliomundi');
			$response = $api->put("webhooks/" . $webhook->tienda_id, $data);

			if($response instanceof \TiendaNube\API\Response){
				if($response->status_code == 200) {

					// Set notice
					Session::flash('alert', __('webhook.sync_success'));
					Session::flash('alert_class','alert-info');
					
					return redirect()->route('webhooks.index', array('nuvemShopId' => $this->nuvemShop->id));
				}	
			}

			// Set notice
				Session::flash('alert', __('webhook.sync_fail'));
			Session::flash('alert_class','alert-warning');
		}
		else {
			// Set notice
			Session::flash('alert', __('webhook.update_success'));
			Session::flash('alert_class','alert-info');	
		}

		return redirect()->route('webhooks.index', array('nuvemShopId' => $this->nuvemShop->id));
	}

	/**
	 * Remove the specified resource from storage.
	 * @param  [type] $nuvemShopId [description]
	 * @param  [type] $webhookId   [description]
	 * @return [type]              [description]
	 */
	public function destroy($nuvemShopId, $webhookId)
	{
		$is_succes = false;

		// Get the webhook
		$webhook = Webhook::findOrFail($webhookId);

		if(!empty($webhook->tienda_id)) {

			$api = new \TiendaNube\API($this->nuvemShop->tiendanube_id, $this->nuvemShop->access_token, 'Bibliomundi');
			$response = $api->delete("webhooks/" . $webhook->tienda_id);

			if($response instanceof \TiendaNube\API\Response){
				if($response->status_code == 200) {

					// Set notice
					Session::flash('alert', __('webhook.sync_success'));
					Session::flash('alert_class','alert-info');
					
					// Destroy model
					$webhook->delete();

					$is_succes = true;
				}	
			}
		}

		if(!$is_succes) {
			// Set notice
			Session::flash('alert', __('webhook.sync_fail'));
			Session::flash('alert_class','alert-warning');
		}

		// Get redirect url
		$redirectURL = url(route('webhooks.index', array('nuvemShopId' => $this->nuvemShop->id)));

		return array('redirect_url' => $redirectURL);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function apiListing()
	{
		/*
		 * Call APIs
		 */
		$api = new \TiendaNube\API($this->nuvemShop->tiendanube_id, $this->nuvemShop->access_token, 'Bibliomundi');
		$response = $api->get("/webhooks");

		// echo json_encode($response);die;

		return view('admin.webhook.pre', array('nuvemShop' => $this->nuvemShop,
												'code' => $response->status_code,
												'body' => $response->body));
	}
}
