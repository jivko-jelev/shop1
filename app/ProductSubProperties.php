<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSubProperties extends Model
{
    protected $table = 'product_sub_properties';

    public $timestamps = false;

    protected $fillable = [
        'product_id', 'subproperty_id',
    ];

}
