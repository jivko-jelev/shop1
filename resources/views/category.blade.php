@extends('partials.master')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::to('styles/shop_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('styles/responsive.css') }}">
@endsection

@section('content')
    <div class="shop">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">

                    <!-- Shop Sidebar -->
                    <div class="shop_sidebar">
                        <div class="sidebar_section filter_by_section">
                            <div class="sidebar_title">Филтри</div>
                            <button class="btn btn-sm btn-primary btn-block" id="clear-filters">Изчисти филтрите</button>
                            <div class="sidebar_subtitle">Цена</div>
                            <div class="filter_price">
                                <div id="slider-range" class="slider_range"></div>
                                <p>Диапазон: </p>
                                <p><input type="text" id="amount" class="amount" readonly style="border:0; font-weight:bold;"></p>
                            </div>
                        </div>
                        <form action="" id="properties">
                            @foreach ($properties as $prop)
                                <div class="sidebar_section">
                                    <div class="sidebar_subtitle brands_subtitle">{{ $prop->name }}</div>
                                    <ul class="brands_list">
                                        @foreach ($prop->subProperties as $subProperty)
                                            <li>
                                                <input class="form-check-input icheckbox_minimal-blue" type="checkbox"
                                                       value="{{ $subProperty->id }}"
                                                       id="filter[{{ $prop->id }}][{{ $subProperty->id }}]"
                                                       name="filter[{{ $prop->id }}][{{ $subProperty->id }}]">
                                                <label class="form-check-label"
                                                       for="filter[{{ $prop->id }}][{{ $subProperty->id }}]">{{ $subProperty->name }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                            <input type="hidden" name="page" id="page" value="{{ $products->currentPage() }}">
                            <input type="hidden" name="order-by" id="order-by" value="newest">
                            <input type="hidden" name="per-page" id="per-page" value="20">
                            <input type="hidden" name="min_price" id="min-price" value="{{ round($prices->min_price) }}">
                            <input type="hidden" name="max_price" id="max-price" value="{{ round($prices->max_price) }}">
                        </form>
                    </div>

                </div>

                <div class="col-lg-9">

                    <!-- Shop Content -->

                    <div class="shop_content">
                        <div class="shop_bar clearfix">
                            <div class="shop_product_count">
                                <span id="num-products">{{ $products->total()  }}</span>
                                <span id="num-products-text">
                                    {{ $products->total() != 0  ? ' намерени продукта' : ' намерен продукт' }}
                                </span>
                            </div>
                            <div class="shop_sorting" id="order-menu">
                                <span>Подреди по:</span>
                                <ul>
                                    <li>
                                        <span class="sorting_text">най-нови<i class="fas fa-chevron-down"></i></span>
                                        <ul>
                                            <li class="shop_sorting_button" data-sort-by='newest'>най-нови</li>
                                            <li class="shop_sorting_button" data-sort-by='promo'>промоции</li>
                                            <li class="shop_sorting_button" data-sort-by='name-asc'>име възх.</li>
                                            <li class="shop_sorting_button" data-sort-by='name-desc'>име низх.</li>
                                            <li class="shop_sorting_button" data-sort-by='order_price-asc'>цена възх.</li>
                                            <li class="shop_sorting_button" data-sort-by='order_price-desc'>цена низх.</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="shop_sorting" id="per-page-menu">
                                <span>Продукти на страница:</span>
                                <ul>
                                    <li>
                                        <span class="sorting_text">20<i class="fas fa-chevron-down"></i></span>
                                        <ul>
                                            <li class="shop_sorting_button" data-per-page='20'>20</li>
                                            <li class="shop_sorting_button" data-per-page='50'>50</li>
                                            <li class="shop_sorting_button" data-per-page='100'>100</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="product_grid">
                            @include('products')
                        </div>
                        @include('layouts.pagination', ['products' => $products])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::to('js/shop_custom.js') }}"></script>
    <script>
        function productStyles() {
            $('.product_item').hover(
                function () {
                    $(this).find('.product_border').hide();
                    $(this).find('.product_cart_button').css('visibility', 'visible').css('opacity', '1');
                    $(this).find('.product_image, .product_price, .product_name').css('position', 'relative').css('top', '-34px');
                },
                function () {
                    $(this).find('.product_border').show();
                    $(this).find('.product_cart_button').css('visibility', 'hidden').css('opacity', '0');
                    $(this).find('.product_image, .product_price, .product_name').css('position', 'initial').css('top', '0px');
                });
        }

        productStyles();
        initIsotope();

        let slider = $('#slider-range');

        function initPriceSlider() {
            if (slider.length) {
                slider.slider(
                    {
                        range: true,
                        min: {{ round($prices->min_price) }},
                        max: {{ round($prices->max_price) }},
                        values: [{{ round($prices->min_price) }}, {{ round($prices->max_price) }}],
                        slide: function (event, ui) {
                            $("#amount").val(ui.values[0] + "лв. - " + ui.values[1] + "лв.");
                        }
                    });

                $("#amount").val(slider.slider("values", 0) + "лв. - " + slider.slider("values", 1) + "лв.");
            }
        }

        initPriceSlider();

        function reloadProducts() {
            $.ajax({
                url: '{{ route('products.index', $categoryName) }}',
                data: $('#properties').serialize(),
                dataType: "json",
                success: function (data) {
                    $('#num-products').html(data.products.total);
                    $('#num-products-text').html(data.products.total != 1 ? ' намерени продукта' : ' намерен продукт');
                    $('.product_grid').html(`${data.view}`);
                    productStyles();
                    $('#pagination').html(data.pagination);
                    $('.pagination li a').click(function (e) {
                        e.preventDefault();
                        paginationClick($(this));
                    });
                    window.history.pushState({}, "", data.requestURI);
                },
                error: function (data) {
                }
            })
        }

        function paginationClick(element) {
            $('#page').val(element.data('page'));
            setTimeout(reloadProducts, 500);
            $("html, body").animate({scrollTop: $('.shop_content').offset().top}, 500);

            let pieces = element.attr('href').split(/[\/]+/);
            pieces     = pieces[pieces.length - 1];
            history.pushState(undefined, "", pieces);
        }

        function initIsotope() {
            $('.shop_sorting_button').on('click', function () {
                $(this).parent().parent().find('.sorting_text').html($(this).text() + '<i class="fas fa-chevron-down"></i>');
                if ($(this).data('sort-by')) {
                    $('#order-by').val($(this).data('sort-by'));
                } else {
                    $('#per-page').val($(this).text());
                }
                $('#page').val(1);
                reloadProducts();
                history.pushState(undefined, "", window.location.href.split('/')[window.location.href.split('/').length - 1].split('?')[0]);
            });
        }

        $('.pagination li a').click(function (e) {
            e.preventDefault();
            paginationClick($(this));
        });
        $(function () {
            function setPriceAndReloadProducts() {
                $('#min-price').val(slider.slider('option', 'values')[0]);
                $('#max-price').val(slider.slider('option', 'values')[1]);
                reloadProducts();
                sliderClick = false;
            }

            function initSlider() {
                slider.slider('option', 'min', {{ round($prices->min_price) }});
                slider.slider('option', 'max', {{ round($prices->max_price) }});
                slider.slider('option', 'values', [{{ round($prices->min_price) }}, {{ round($prices->max_price) }}]);
                $("#amount").val(slider.slider("values", 0) + "лв. - " + slider.slider("values", 1) + "лв.");
                $('#min-price').val(slider.slider('option', 'values')[0]);
                $('#max-price').val(slider.slider('option', 'values')[1]);
            }

            initSlider();

            let sliderClick = false;
            $(document).on('mouseup', function (e) {
                if (sliderClick) {
                    setPriceAndReloadProducts();
                }
            });

            slider.on('mousedown', function () {
                sliderClick = true;
            });

            function captureCheckboxes() {
                $('input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass: 'iradio_minimal-blue'
                });
                $('.form-check-input').on('ifChanged', function () {
                    $('#page').val(1);
                    history.pushState(undefined, "", window.location.href.split('/')[window.location.href.split('/').length - 1].split('?')[0]);
                    reloadProducts();
                });
            }

            captureCheckboxes();
            $('#clear-filters').click(function () {
                $('#properties input[type=checkbox]').each(function () {
                    $(this).prop('checked', false);
                });
                captureCheckboxes();
                initSlider();
                $('#page').val(1);
                $('#order-by').val('newest');
                $('#per-page').val(20);
                $('#per-page-menu .sorting_text').html($('#per-page-menu').find('.shop_sorting_button:first-child').html() + '<i class="fas fa-chevron-down"></i>');
                $('#order-menu .sorting_text').html($('#order-menu').find('.shop_sorting_button:first-child').html() + '<i class="fas fa-chevron-down"></i>');
                reloadProducts();
            });
        });

        $('.product_cart_button').click(function () {
            window.location.href = $(this).find('a').attr('href');
        });
    </script>
@endsection