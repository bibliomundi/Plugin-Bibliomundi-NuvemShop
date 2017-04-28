<?php

namespace App\Http\Middleware;

use Closure;
use Log;  
use Response;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Nuvemshop;

class VerifyWebhook
{
	public $appSecret;

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// Get nuvem shop from DB
		$store_id = $request->store_id;
		$nuvemShop = Nuvemshop::where('tiendanube_id', '=', $store_id)->first();
		if(empty($nuvemShop)) {
			return response()->json(['message' => __('callback.store_not_found')], 404);
		}
        $this->appSecret = $nuvemShop->client_secret;

        // Get header HTTP_X_LINKEDSTORE_HMAC_SHA256
		$hmac_header = $request->header('x-linkedstore-hmac-sha256');

        // Get data from request, then hash
        $content = $request->getContent();
        $content_hashed = hash_hmac('sha256', $content, $this->appSecret);
		
        // Verify
		if($content_hashed == $hmac_header) {
			return $next($request);
		}
		else {
			return response()->json(['message' => 'Wrong HTTP_X_LINKEDSTORE_HMAC_SHA256.'], 401);
		}
	}
}
