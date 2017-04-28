<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bibliomundi extends Model
{
	public $setting;

	public function __construct($setting = array())
	{
		if(!empty($setting)) {
			$this->setting = $setting;
		}
		else {
			foreach (Setting::get() as $setting) {
				$this->setting[$setting->key] = $setting->value;
			}
		}
	}

	public function getCatalog()
	{
		$catalog = new \BBM\Catalog($this->setting['bbm_client_id'], $this->setting['bbm_client_secret'], $this->setting['bbm_operation']);
		$catalog->environment = $this->setting['bbm_environment'];
		//$catalog->verbose(true);

		try
		{
			$catalog->validate();
			return $catalog->get();
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

	/**
	 * Function to purchase an order on BilioMundi
	 * @param  [type] $order [description]
	 * @return [type]           [description]
	 */
	public function purchase($order)
	{	
		// Validate
		if(empty($order['id']) || empty($order['customer']) || empty($order['products'])) {
			return array(
				'status' => 'Failed',
				'message' => __('callback.order_missing_param')
			);
		}

		// Get BibiloMundi Purchase instant
		$purchase = new \BBM\Purchase($this->setting['bbm_client_id'], $this->setting['bbm_client_secret']);
		$purchase->environment = $this->setting['bbm_environment'];

		// Set customer
		$purchase->setCustomer($order['customer']);

		// Set products
		foreach ($order['products'] as $product) {
			$purchase->addItem($product['id'], $product['price'], $product['currency']);
		}

		try {
			// BilioMundi - Validate
			$purchase->validate();

			// BilioMundi - Checkout
			$json_checkout = $purchase->checkout($order['id'], time());
			
			return json_decode($json_checkout);
		}
		catch(\BBM\Server\Exception $e) {
			throw $e;
		}
	}

	/**
	 * Function to get link down load of the products of an order on BilioMundi
	 * @param  [type] $orderId   [description]
	 * @param  [type] $productId [description]
	 * @return [type]            [description]
	 */
	public function download($orderId, $productId)
	{
		// Get BiblioMundi Download instance
		$download = new \BBM\Download($this->setting['bbm_client_id'], $this->setting['bbm_client_secret']);
		$download->environment = $this->setting['bbm_environment'];

		try {
			$data = array(
				'ebook_id' => intval($productId),
				'transaction_time' => time(),
				'transaction_key' => $orderId
			);

			$download->validate($data);

			$download->download();
		}
		catch(\BBM\Server\Exception $e) {
			throw $e;
		}
	}
}
