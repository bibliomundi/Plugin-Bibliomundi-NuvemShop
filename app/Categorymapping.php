<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorymapping extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories_mapping';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bbm_id_category'
    ]; 
}
