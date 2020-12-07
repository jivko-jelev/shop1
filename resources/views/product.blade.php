@extends('partials.master')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::to('styles/product_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('styles/product_responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <style type="text/css">
        .slick-slide img {
            width: 100%;
        }

        .slider button, .slider ul {
            display: none !important;
        }

    </style>
@endsection

@section('content')
    <div class="single_product">
        @if(Session::has('message'))
            <div class="col-md-4 offset-4">
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
            </div>
        @endif
        <div class="container">
            <div class="row">
                <!-- Images -->
                <div class="col-lg-5">
                    <div class="slider slider-for">
                        <div>
                            <img src="{{ $product->getPictureThumbnail() }}" class="img-responsive" style="width: 100% !important">
                        </div>
                        @if(count($product->pictures) > 0)
                            @foreach($product->pictures as $picture)
                                <div>
                                    <img src="{{ URL::to($picture->filename) }}">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="slider slider-nav">
                        @if(count($product->pictures) > 0)
                            <div>
                                <img src="{{ $product->getPicture() }}">
                            </div>
                            @foreach($product->pictures as $picture)
                                <div>
                                    <img src="{{ URL::to($picture->filename) }}">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="col-lg-5 order-3">
                    <div class="product_description">
                        <div class="product_category">{{ $product->category->title }}</div>
                        <div class="product_name">{{ $product->name }}</div>
                        <div class="product_rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                        <div class="product_text">{!! $product->description !!}</div>
                        <div class="order_info d-flex flex-row">
                            <form action="{{ route('carts.store', $product) }}" method="post" autocomplete="off">
                                <div class="clearfix" style="z-index: 1000;">

                                    <!-- Product Quantity -->
                                    <div class="product_quantity">
                                        <span>Quantity: </span>
                                        <input id="quantity_input" name="quantity" type="text" pattern="[0-9]*" value="1">
                                        <div class="quantity_buttons">
                                            <div id="quantity_inc_button" class="quantity_inc quantity_control"><i
                                                        class="fas fa-chevron-up"></i></div>
                                            <div id="quantity_dec_button" class="quantity_dec quantity_control"><i
                                                        class="fas fa-chevron-down"></i></div>
                                        </div>
                                        @error('quantity')
                                        <p class="error-quantity">задължително</p>
                                        @enderror
                                    </div>

                                    @if($product->type == 'Вариация')
                                        <div style="display: inline-block">
                                            <select name="variation" id="variation">
                                                <option value="">избери</option>
                                                @foreach($product->variation->subVariations as $subVariations)
                                                    <option value="{{ $subVariations->id }}">{{ $subVariations->name }}</option>
                                                @endforeach
                                            </select>
                                            <ul class="product_color">
                                                <li>
                                                    <span>{{ $product->variation->name }}: </span>
                                                    <div class="color_mark_container">
                                                        <div id="selected_variation">избери</div>
                                                    </div>
                                                    <div class="color_dropdown_button"><i class="fas fa-chevron-down"></i></div>

                                                    <ul class="variation_list">
                                                        @foreach($product->variation->subVariations as $subVariations)
                                                            <li>{{ $subVariations->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            </ul>
                                            @error('variation')
                                            <p class="error">задължително</p>
                                            @enderror
                                        </div>
                                    @endif

                                </div>

                                @if($product->promo_price)
                                    <div class="product_price discount">{!! $product->promoPriceText() !!}
                                        <span>{!! $product->priceText() !!}</span></div>
                                @else
                                    <div class="product_price">{!! $product->priceText() !!}</div>
                                @endif
                                <div class="button_container">
                                    <button type="submit" class="button cart_button">Добави в количката</button>
                                    <div class="product_fav"><i class="fas fa-heart"></i></div>
                                </div>
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::to('js/product_custom.js') }}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            dots: true,
            centerMode: true,
            focusOnSelect: true
        });
    </script>
@endsection