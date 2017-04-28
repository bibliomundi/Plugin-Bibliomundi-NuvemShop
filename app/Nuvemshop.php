<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nuvemshop extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nuvemshops';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id'
    ];

    /**
     * Get the webhooks of the shop.
     */
    public function webhooks()
    {
        return $this->hasMany('App\Webhook');
    }

    /**
     * Get the EmailTemplate of the shop.
     */
    public function emailTemplate()
    {
        return $this->hasOne('App\EmailTemplate');
    }
}
