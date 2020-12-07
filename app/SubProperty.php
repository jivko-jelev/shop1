<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubProperty extends Model
{
    protected $table = 'sub_properties';

    protected $fillable = ['name', 'property_id'];

    public $timestamps = false;

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

}
