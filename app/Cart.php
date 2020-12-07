<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'subvariation_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function total($cart)
    {
        $total = 0;
        foreach ($cart as $c) {
            $total += $c->quantity * $c->product->real_price;
        }

        return $total;
    }

    public function totalProductPriceText()
    {
        $totalPrice = $this->quantity * $this->product->real_price;
        $totalPrice = number_format((float)$totalPrice, 2, '.', '');

        $dot = str_replace('.', '<sup>', $totalPrice) . '</sup>';

        return $dot;
    }
}
