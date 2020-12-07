<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['name', 'category_id', 'multiple_selection_allowed'];

    public $timestamps = false;

    public function subProperties()
    {
        return $this->hasMany(SubProperty::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
