<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $carts = Cart::with(['product', 'user'])
                     ->where('user_id', Auth::id())
                     ->get();

        return view('cart', ['carts' => $carts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product                  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'variation' => Rule::requiredIf($product->type == 'Вариация'),
            'quantity'  => 'required|numeric|min:1',
        ]);

        $cart = Cart::firstOrNew([
            'product_id'      => $product->id,
            'user_id'         => Auth::id(),
            'subvariation_id' => $request->get('variation'),
        ]);

        $cart->product_id      = $product->id;
        $cart->user_id         = Auth::id();
        $cart->quantity        += $request->get('quantity');
        $cart->subvariation_id = $request->get('variation');
        $cart->save();

        return redirect()->back()->with(['message' => 'Продуктът бе добавен във Вашата количка']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Cart                $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
