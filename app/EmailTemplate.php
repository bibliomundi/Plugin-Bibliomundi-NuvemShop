<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nuvemshop_id', 'from_name', 'from_address', 'subject', 'header', 'footer', 'content'];
    
    /**
     * Get the shop that owns the webhook.
     */
    public function nuvemshop()
    {
    	return $this->belongsTo('App\Nuvemshop');
    }
}
