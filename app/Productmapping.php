<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productmapping extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products_mapping';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bbm_id_product', 'nuvem_id_product', 'tiendanube_id'
    ];   
}
