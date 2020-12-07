@php
    $cart = App\Cart::where('user_id', Auth::id())->get()
@endphp

        <!DOCTYPE html>
<html lang="en">
<head>
    <title>Shop</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="OneTech shop project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('styles/bootstrap4/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('plugins/fontawesome-free-5.0.1/css/fontawesome-all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('plugins/OwlCarousel2-2.2.1/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('plugins/OwlCarousel2-2.2.1/owl.theme.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('plugins/OwlCarousel2-2.2.1/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('plugins/jquery-ui-1.12.1.custom/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('plugins/iCheck/all.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/general.css') }}">
    @yield('styles')
</head>

<body>

<div class="super_container">
    <!-- Header -->

    <header class="header">

        <!-- Top Bar -->

        <div class="top_bar">
            <div class="container">
                <div class="row">
                    <div class="col d-flex flex-row">
                        <div class="top_bar_contact_item">
                            <div class="top_bar_icon"><img src="{{ URL::to('images/phone.png') }}" alt=""></div>
                            {{ env('PHONE') }}
                        </div>
                        <div class="top_bar_contact_item">
                            <div class="top_bar_icon"><img src="{{ URL::to('images/mail.png') }}" alt=""></div>
                            <a href="mailto:{{ env('EMAIL') }}">{{ env('EMAIL') }}</a></div>
                        <div class="top_bar_content ml-auto">
                            <div class="top_bar_user">
                                <div class="user_icon"><img src="{{ URL::to('images/user.svg') }}" alt=""></div>
                                @if(!Auth::check())
                                    <div><a href="{{ route('register') }}">Регистрация</a></div>
                                    <div><a href="{{ route('login') }}">Влез</a></div>
                                @else
                                    <div>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Изход') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header Main -->

        <div class="header_main">
            <div class="container">
                <div class="row">

                    <!-- Logo -->
                    <div class="col-lg-2 col-sm-3 col-3 order-1">
                        <div class="logo_container">
                            <div class="logo"><a href="#">OneTech</a></div>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
                        <div class="header_search">
                            <div class="header_search_content">
                                <div class="header_search_form_container">
                                    <form action="#" class="header_search_form clearfix">
                                        <input type="search" required="required" class="header_search_input"
                                               placeholder="Търсене...">
                                        <div class="custom_dropdown">
                                            <div class="custom_dropdown_list">
                                                <span class="custom_dropdown_placeholder clc">Всички категории</span>
                                                <i class="fas fa-chevron-down"></i>
                                                <ul class="custom_list clc">
                                                    <li><a class="clc" href="#">Всички категории</a></li>
                                                    @foreach($categories->where('parent_id', null) as $category)
                                                        <li><a class="clc" href="#">{{ $category->title }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <button type="submit" class="header_search_button trans_300" value="Submit"><img
                                                    src="{{ URL::to('images/search.png') }}" alt=""></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Wishlist -->
                    <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
                        <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                            <div class="wishlist d-flex flex-row align-items-center justify-content-end">
                                <div class="wishlist_icon"><img src="{{ URL::to('images/heart.png') }}" alt=""></div>
                                <div class="wishlist_content">
                                    <div class="wishlist_text"><a href="#">Любими</a></div>
                                    <div class="wishlist_count">115</div>
                                </div>
                            </div>

                            <!-- Cart -->
                            <div class="cart">
                                <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                                    <div class="cart_icon">
                                        <img src="{{ URL::to('images/cart.png') }}" alt="">
                                        <div class="cart_count">
                                            <span>
                                                {{ count($cart) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="cart_content">
                                        <div class="cart_text"><a href="{{ route('carts.index') }}">Количка</a></div>
                                        <div class="cart_price">85 лв.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Navigation -->

        <nav class="main_nav">
            <div class="container">
                <div class="row">
                    <div class="col">

                        <div class="main_nav_content d-flex flex-row">

                            <!-- Categories Menu -->

                            <div class="cat_menu_container">
                                <div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
                                    <div class="cat_burger"><span></span><span></span><span></span></div>
                                    <div class="cat_menu_text">категории</div>
                                </div>

                                {!! \App\Category::generateMenu($categories) !!}
                            </div>

                            <!-- Main Nav Menu -->

                            <div class="main_nav_menu ml-auto">
                                <ul class="standard_dropdown main_nav_dropdown">
                                    <li><a href="#">Home<i class="fas fa-chevron-down"></i></a></li>
                                    <li class="hassubs">
                                        <a href="#">Super Deals<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <li>
                                                <a href="#">Menu Item<i class="fas fa-chevron-down"></i></a>
                                                <ul>
                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="hassubs">
                                        <a href="#">Featured Brands<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <li>
                                                <a href="#">Menu Item<i class="fas fa-chevron-down"></i></a>
                                                <ul>
                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li class="hassubs">
                                        <a href="#">Pages<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <li><a href="shop.html">Shop<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="product.html">Product<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="blog.html">Blog<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="blog_single.html">Blog Post<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="regular.html">Regular Post<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="cart.html">Cart<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="contact.html">Contact<i class="fas fa-chevron-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li><a href="blog.html">Blog<i class="fas fa-chevron-down"></i></a></li>
                                    <li><a href="contact.html">Contact<i class="fas fa-chevron-down"></i></a></li>
                                </ul>
                            </div>

                            <!-- Menu Trigger -->

                            <div class="menu_trigger_container ml-auto">
                                <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                                    <div class="menu_burger">
                                        <div class="menu_trigger_text">menu</div>
                                        <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Menu -->

        <div class="page_menu">
            <div class="container">
                <div class="row">
                    <div class="col">

                        <div class="page_menu_content">

                            <div class="page_menu_search">
                                <form action="#">
                                    <input type="search" required="required" class="page_menu_search_input"
                                           placeholder="Search for products...">
                                </form>
                            </div>
                            <ul class="page_menu_nav">
                                <li class="page_menu_item has-children">
                                    <a href="#">Language<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">English<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Italian<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Spanish<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Japanese<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item has-children">
                                    <a href="#">Currency<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">US Dollar<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">EUR Euro<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">GBP British Pound<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">JPY Japanese Yen<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item">
                                    <a href="#">Home<i class="fa fa-angle-down"></i></a>
                                </li>
                                <li class="page_menu_item has-children">
                                    <a href="#">Super Deals<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">Super Deals<i class="fa fa-angle-down"></i></a></li>
                                        <li class="page_menu_item has-children">
                                            <a href="#">Menu Item<i class="fa fa-angle-down"></i></a>
                                            <ul class="page_menu_selection">
                                                <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item has-children">
                                    <a href="#">Featured Brands<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">Featured Brands<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item has-children">
                                    <a href="#">Trending Styles<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">Trending Styles<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item"><a href="blog.html">blog<i class="fa fa-angle-down"></i></a></li>
                                <li class="page_menu_item"><a href="contact.html">contact<i class="fa fa-angle-down"></i></a></li>
                            </ul>

                            <div class="menu_contact">
                                <div class="menu_contact_item">
                                    <div class="menu_contact_icon"><img src="{{ URL::to('images/phone_white.png') }}" alt="">
                                    </div>
                                    +38 068 005 3570
                                </div>
                                <div class="menu_contact_item">
                                    <div class="menu_contact_icon"><img src="{{ URL::to('images/mail_white.png') }}" alt=""></div>
                                    <a href="mailto:fastsales@gmail.com">fastsales@gmail.com</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>

@isset($categoryTitle)
    <!-- Home -->
        <div class="home">
            <div class="home_background parallax-window" data-parallax="scroll"
                 data-image-src="{{ URL::to('images/shop_background.jpg') }}"></div>
            <div class="home_overlay"></div>
            <div class="home_content d-flex flex-column align-items-center justify-content-center">
                <h2 class="home_title">{{ $categoryTitle }}</h2>
            </div>
        </div>
@endisset
<!-- Shop -->
@yield('content')
<!-- Brands -->

{{--    <div class="brands">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col">--}}
{{--                    <div class="brands_slider_container">--}}

{{--                        <!-- Brands Slider -->--}}

{{--                        <div class="owl-carousel owl-theme brands_slider">--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="brands_item d-flex flex-column justify-content-center"><img--}}
{{--                                            src="{{ URL::to('images/brands_1.jpg') }}"--}}
{{--                                            alt="">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="brands_item d-flex flex-column justify-content-center"><img--}}
{{--                                            src="{{ URL::to('images/brands_2.jpg') }}"--}}
{{--                                            alt="">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="brands_item d-flex flex-column justify-content-center"><img--}}
{{--                                            src="{{ URL::to('images/brands_3.jpg') }}"--}}
{{--                                            alt="">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="brands_item d-flex flex-column justify-content-center"><img--}}
{{--                                            src="{{ URL::to('images/brands_4.jpg') }}"--}}
{{--                                            alt="">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="brands_item d-flex flex-column justify-content-center"><img--}}
{{--                                            src="{{ URL::to('images/brands_5.jpg') }}"--}}
{{--                                            alt="">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="brands_item d-flex flex-column justify-content-center"><img--}}
{{--                                            src="{{ URL::to('images/brands_6.jpg') }}"--}}
{{--                                            alt="">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="brands_item d-flex flex-column justify-content-center"><img--}}
{{--                                            src="{{ URL::to('images/brands_7.jpg') }}"--}}
{{--                                            alt="">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="brands_item d-flex flex-column justify-content-center"><img--}}
{{--                                            src="{{ URL::to('images/brands_8.jpg') }}"--}}
{{--                                            alt="">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <!-- Brands Slider Navigation -->--}}
{{--                        <div class="brands_nav brands_prev"><i class="fas fa-chevron-left"></i></div>--}}
{{--                        <div class="brands_nav brands_next"><i class="fas fa-chevron-right"></i></div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Newsletter -->

    <div class="newsletter">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
                        <div class="newsletter_title_container">
                            <div class="newsletter_icon"><img src="{{ URL::to('images/send.png') }}" alt=""></div>
                            <div class="newsletter_title">Sign up for Newsletter</div>
                            <div class="newsletter_text"><p>...and receive %20 coupon for first shopping.</p></div>
                        </div>
                        <div class="newsletter_content clearfix">
                            <form action="#" class="newsletter_form">
                                <input type="email" class="newsletter_input" required="required"
                                       placeholder="Enter your email address">
                                <button class="newsletter_button">Subscribe</button>
                            </form>
                            <div class="newsletter_unsubscribe_link"><a href="#">unsubscribe</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->

    <footer class="footer">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 footer_col">
                    <div class="footer_column footer_contact">
                        <div class="logo_container">
                            <div class="logo"><a href="#">OneTech</a></div>
                        </div>
                        <div class="footer_title">Got Question? Call Us 24/7</div>
                        <div class="footer_phone">+38 068 005 3570</div>
                        <div class="footer_contact_text">
                            <p>17 Princess Road, London</p>
                            <p>Grester London NW18JR, UK</p>
                        </div>
                        <div class="footer_social">
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                <li><a href="#"><i class="fab fa-google"></i></a></li>
                                <li><a href="#"><i class="fab fa-vimeo-v"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 offset-lg-2">
                    <div class="footer_column">
                        <div class="footer_title">Find it Fast</div>
                        <ul class="footer_list">
                            <li><a href="#">Computers & Laptops</a></li>
                            <li><a href="#">Cameras & Photos</a></li>
                            <li><a href="#">Hardware</a></li>
                            <li><a href="#">Smartphones & Tablets</a></li>
                            <li><a href="#">TV & Audio</a></li>
                        </ul>
                        <div class="footer_subtitle">Gadgets</div>
                        <ul class="footer_list">
                            <li><a href="#">Car Electronics</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="footer_column">
                        <ul class="footer_list footer_list_2">
                            <li><a href="#">Video Games & Consoles</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Cameras & Photos</a></li>
                            <li><a href="#">Hardware</a></li>
                            <li><a href="#">Computers & Laptops</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2">
                    <div class="footer_column">
                        <div class="footer_title">Customer Care</div>
                        <ul class="footer_list">
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">Order Tracking</a></li>
                            <li><a href="#">Wish List</a></li>
                            <li><a href="#">Customer Services</a></li>
                            <li><a href="#">Returns / Exchange</a></li>
                            <li><a href="#">FAQs</a></li>
                            <li><a href="#">Product Support</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </footer>

    <!-- Copyright -->

    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col">

                    <div class="copyright_container d-flex flex-sm-row flex-column align-items-center justify-content-start">
                        <div class="copyright_content">
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                            All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a
                                    href="https://colorlib.com" target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </div>
                        <div class="logos ml-sm-auto">
                            <ul class="logos_list">
                                <li><a href="#"><img src="{{ URL::to('images/logos_1.png') }}" alt=""></a></li>
                                <li><a href="#"><img src="{{ URL::to('images/logos_2.png') }}" alt=""></a></li>
                                <li><a href="#"><img src="{{ URL::to('images/logos_3.png') }}" alt=""></a></li>
                                <li><a href="#"><img src="{{ URL::to('images/logos_4.png') }}" alt=""></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ URL::to('bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::to('plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ URL::to('styles/bootstrap4/popper.js') }}"></script>
<script src="{{ URL::to('styles/bootstrap4/bootstrap.min.js') }}"></script>
<script src="{{ URL::to('plugins/greensock/TweenMax.min.js') }}"></script>
<script src="{{ URL::to('plugins/greensock/TimelineMax.min.js') }}"></script>
<script src="{{ URL::to('plugins/scrollmagic/ScrollMagic.min.js') }}"></script>
<script src="{{ URL::to('plugins/greensock/animation.gsap.min.js') }}"></script>
<script src="{{ URL::to('plugins/greensock/ScrollToPlugin.min.js') }}"></script>
<script src="{{ URL::to('plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
<script src="{{ URL::to('plugins/easing/easing.js') }}"></script>
<script src="{{ URL::to('plugins/Isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ URL::to('plugins/jquery-ui-1.12.1.custom/jquery-ui.js') }}"></script>
<script src="{{ URL::to('plugins/parallax-js-master/parallax.min1.js') }}"></script>
@yield('scripts')
</body>

</html>