<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['nuvemshop_id', 'status', 'tienda_id', 'event', 'url'];
	
	/**
	 * Get the shop that owns the webhook.
	 */
	public function nuvemshop()
	{
		return $this->belongsTo('App\Nuvemshop');
	}
}
