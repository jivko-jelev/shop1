<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubVariation extends Model
{
    protected $fillable = ['name', 'variation_id'];

    public $timestamps = false;
}
