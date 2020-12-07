@extends('partials.master')

@section('styles')
    <link rel="stylesheet" type="text/css" href="styles/cart_styles.css">
    <link rel="stylesheet" type="text/css" href="styles/cart_responsive.css">
@endsection

@section('content')
    <!-- Cart -->

    <div class="cart_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="cart_container">
                        <div class="cart_title">Shopping Cart</div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                <th>Снимка</th>
                                <th>Име</th>
                                <th>Вариация</th>
                                <th>Брой</th>
                                <th class="text-right">Ед. цена</th>
                                <th class="text-right">Общо</th>
                                </thead>
                                <tbody>
                                @forelse($carts as $cart)
                                    <tr>
                                        <td><img src="{{ $cart->product->getPrimaryPictureThumbnail(0) }}" alt=""></td>
                                        <td>{{ $cart->product->name }}</td>
                                        <td>{!! isset($cart->variation_name) ? "{$cart->variation_name}: <strong>{$cart->subvariation_name}</strong>" : 'N / A' !!}</td>
                                        <td>
                                            <select name="quantity" class="form-control">
                                                @for($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}" {{ $i == $cart->quantity ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td class="text-right">@priceText($cart->product->real_price)</td>
                                        <td class="text-right">@priceText($cart->product->real_price * $cart->quantity)</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>Вашата количка е празна</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Order Total -->
                        <div class="order_total">
                            <div class="order_total_content text-md-right">
                                <div class="order_total_title">Обща стойност на поръчката:</div>
                                <div class="order_total_amount">@priceText(App\Cart::total($carts))</div>
                            </div>
                        </div>

                        <div class="cart_buttons">
                            <button type="button" class="button cart_button_clear">Add to Cart</button>
                            <button type="button" class="button cart_button_checkout">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection