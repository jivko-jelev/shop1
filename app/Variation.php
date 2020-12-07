<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $table = 'variations';

    protected $fillable = ['name', 'product_id'];

    public $timestamps = false;

    public function subVariations()
    {
        return $this->hasMany('App\SubVariation');
    }
}
