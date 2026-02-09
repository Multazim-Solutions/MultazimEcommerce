<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Multazim') }} - Storefront</title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('css/multazim-storefront.css') }}">
    <link rel="stylesheet" href="{{ asset('css/multazim-storefront-overrides.css') }}">
</head>
<body>
@php
    $fallbackImageUrl = asset('brand/multazim_logo.png');
    $productsDisk = \Illuminate\Support\Facades\Storage::disk('products');
    $resolveProductImageUrl = static function (?string $path) use ($productsDisk, $fallbackImageUrl): string {
        if ($path === null || $path === '' || !$productsDisk->exists($path)) {
            return $fallbackImageUrl;
        }

        return $productsDisk->url($path);
    };
@endphp

<header class="header_area sticky_header">
    <div class="header_middle">
        <div class="container">
            <div class="row">
                <div class="col-xxl-3 col-xl-3 col-lg-2 d-none d-lg-block">
                    <div class="header_middle_logo">
                        <a href="{{ route('storefront.home') }}">
                            <img src="{{ asset('brand/multazim_logo.png') }}" alt="{{ config('app.name', 'Multazim') }}">
                        </a>
                    </div>
                </div>

                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                    <div class="header_mobile_device d-lg-none d-md-block">
                        <div class="header_mobile_table_cell">
                            <a class="header_mobile_toggle" data-bs-toggle="offcanvas" href="#offcanvasMenuId" role="button" aria-label="Open menu">
                                <i class="fa-solid fa-bars"></i>
                            </a>

                            <div class="header_mobile_logo">
                                <a href="{{ route('storefront.home') }}">
                                    <img src="{{ asset('brand/multazim_logo.png') }}" alt="{{ config('app.name', 'Multazim') }}">
                                </a>
                            </div>

                            <div class="header_mobile_search" onclick="search()">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                        </div>
                    </div>

                    <div id="search_id" class="header_middle_search_content search_class">
                        <div class="header_middle_search">
                            <form action="{{ route('storefront.products.index') }}" method="GET">
                                <input
                                    type="text"
                                    id="searchboxinput"
                                    name="q"
                                    class="search__product"
                                    placeholder="Search products"
                                    value="{{ request('q') }}"
                                >
                                <button type="submit" class="header_middle_search_link" aria-label="Search">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-4 col-lg-5 d-none d-lg-block">
                    <div class="header_middle_table_cell">
                        <div class="header_middle_call">
                            <a href="tel:01317448899" class="header_middle_call_link">
                                <div class="header_middle_call_icon">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <div class="header_middle_call_text">
                                    <p>Call Us Now:</p>
                                    <span>01317448899</span>
                                </div>
                            </a>
                        </div>

                        <div class="header_middle_wishlist">
                            <a href="{{ route('storefront.cart.index') }}" class="header_middle_wishlist_link" aria-label="Cart">
                                <div class="header_middle_wishlist_icon">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                            </a>
                        </div>

                        <div class="header_middle_auth">
                            @auth
                                <a href="{{ route('dashboard') }}" class="header_middle_auth_link">
                                    <div class="header_middle_icon">
                                        <i class="fa-regular fa-user"></i>
                                    </div>
                                    <div class="header_middle_text">
                                        <span>Hi,</span>
                                        <span>{{ Auth::user()->name }}</span>
                                    </div>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="header_middle_auth_link">
                                    <div class="header_middle_icon">
                                        <i class="fa-regular fa-user"></i>
                                    </div>
                                    <div class="header_middle_text">
                                        <span>Hi,</span>
                                        <span>Login/Sign up</span>
                                    </div>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header_bottom d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="main_menu text-center">
                        <ul>
                            @foreach ($menuItems as $menuItem)
                                <li>
                                    <a href="{{ $menuItem['url'] }}" class="main_menu_link">{{ $menuItem['label'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="content">
    <div class="banner_area section_padding_bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="slider_banner_active owl-carousel">
                        @forelse ($heroProducts as $heroProduct)
                            @php
                                $heroImage = $heroProduct->images->sortBy('sort_order')->first();
                                $heroImageUrl = $resolveProductImageUrl($heroImage?->path);
                            @endphp
                            <div class="slider_banner_item">
                                <a href="{{ route('storefront.products.show', $heroProduct) }}">
                                    <img src="{{ $heroImageUrl }}" alt="{{ $heroImage?->alt_text ?? $heroProduct->name }}">
                                </a>
                            </div>
                        @empty
                            <div class="slider_banner_item">
                                <a href="{{ route('storefront.products.index') }}">
                                    <img src="{{ asset('brand/multazim_logo.png') }}" alt="{{ config('app.name', 'Multazim') }}">
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="category_area section_padding_bottom">
        <div class="container">
            <div class="row">
                <div class="col-12 category_title_area">
                    <div class="section_title text-center">
                        <h2>Categories</h2>
                    </div>
                    <div class="view_all_category">
                        <a href="{{ route('storefront.products.index') }}" class="category_list_link_view_all">View All</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container section_top_space">
            <div class="category_container_items">
                @forelse ($categoryProducts as $categoryProduct)
                    @php
                        $categoryImage = $categoryProduct->images->sortBy('sort_order')->first();
                        $categoryImageUrl = $resolveProductImageUrl($categoryImage?->path);
                    @endphp
                    <div class="category_item">
                        <a href="{{ route('storefront.products.show', $categoryProduct) }}" class="category_item_link">
                            <div class="category_image">
                                <img src="{{ $categoryImageUrl }}" alt="{{ $categoryImage?->alt_text ?? $categoryProduct->name }}">
                            </div>
                            <div class="category_name">
                                <p>{{ \Illuminate\Support\Str::limit($categoryProduct->name, 30) }}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="empty_category_state">
                        <p>Products are not available yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @php
        $sectionClasses = [
            'new_arrival_area',
            'hot_selling_area',
            'new_arrival_product_area',
            'top_selling_area',
        ];
        $carouselClasses = [
            'new_arrival_active',
            'hot_selling_active',
            'new_arrival_product_active',
            'top_selling_active',
        ];
    @endphp

    @foreach ($productSections as $section)
        <section class="{{ $sectionClasses[$loop->index] ?? 'new_arrival_area' }} section_padding_bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section_title text-center">
                            <h2>{{ $section['title'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container section_top_space">
                <div class="row">
                    <div class="col-12">
                        <div class="{{ $carouselClasses[$loop->index] ?? 'new_arrival_active' }} product_carousel owl-carousel">
                            @foreach ($section['products'] as $product)
                                @php
                                    $sortedImages = $product->images->sortBy('sort_order')->values();
                                    $primaryImage = $sortedImages->get(0);
                                    $hoverImage = $sortedImages->get(1);
                                    $primaryImageUrl = $resolveProductImageUrl($primaryImage?->path);
                                    $hoverImageUrl = $hoverImage?->path !== null && $hoverImage?->path !== '' && $productsDisk->exists($hoverImage->path)
                                        ? $productsDisk->url($hoverImage->path)
                                        : null;
                                    $displayPrice = rtrim(rtrim(number_format((float) $product->price, 2, '.', ''), '0'), '.');
                                @endphp
                                <div class="product_card">
                                    <div class="product_image">
                                        <a href="{{ route('storefront.products.show', $product) }}">
                                            <img src="{{ $primaryImageUrl }}" alt="{{ $primaryImage?->alt_text ?? $product->name }}">
                                            @if ($hoverImageUrl !== null)
                                                <img class="hover_image" src="{{ $hoverImageUrl }}" alt="{{ $hoverImage?->alt_text ?? $product->name }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="product_content">
                                        <div class="product_name">
                                            <a href="{{ route('storefront.products.show', $product) }}" class="product_name_link">
                                                {{ \Illuminate\Support\Str::limit($product->name, 56) }}
                                            </a>
                                        </div>
                                        <div class="product_price">
                                            <span class="product_new_price">{{ $displayPrice }} TK</span>
                                        </div>
                                        <div class="product_btn">
                                            <a href="{{ route('storefront.products.show', $product) }}" class="product_btn_link">Order Now</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach

    <section class="service_area section_padding_bottom d-none d-lg-block">
        <div class="container">
            <div class="row gy-4">
                @php
                    $serviceIcons = [
                        'fa-solid fa-thumbs-up',
                        'fa-solid fa-headset',
                        'fa-solid fa-truck',
                        'fa-solid fa-credit-card',
                    ];
                @endphp
                @foreach ($serviceHighlights as $serviceHighlight)
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
                        <div class="service_item">
                            <div class="service_icon">
                                <i class="{{ $serviceIcons[$loop->index] ?? 'fa-solid fa-star' }}"></i>
                            </div>
                            <div class="service_title">
                                <h4>{{ $serviceHighlight['title'] }}</h4>
                            </div>
                            <div class="service_description">
                                <p>{{ $serviceHighlight['description'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

<footer class="footer_area">
    <div class="footer_top">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="footer_content">
                        <div class="footer_logo">
                            <a href="{{ route('storefront.home') }}">
                                <img src="{{ asset('brand/multazim_logo.png') }}" alt="{{ config('app.name', 'Multazim') }}">
                            </a>
                        </div>
                        <div class="footer_description">
                            <p>{{ request()->getHost() }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-3 col-sm-3 col-6">
                    <div class="footer_content">
                        <div class="footer_title">
                            <h4>Quick Links</h4>
                        </div>
                        <div class="footer_list">
                            <ul>
                                @foreach ($quickLinks as $quickLink)
                                    <li>
                                        <a href="{{ $quickLink['url'] }}" class="footer_list_link">{{ $quickLink['label'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-3 col-sm-3 col-6">
                    <div class="footer_content">
                        <div class="footer_title">
                            <h4>Information</h4>
                        </div>
                        <div class="footer_list">
                            <ul>
                                @foreach ($informationLinks as $informationLink)
                                    <li>
                                        <a href="{{ $informationLink['url'] }}" class="footer_list_link">{{ $informationLink['label'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="footer_content">
                        <div class="footer_title">
                            <h4>Follow Us</h4>
                        </div>
                        <div class="footer_list">
                            <ul>
                                <li>
                                    <a href="https://www.facebook.com/multazimbd/" target="_blank" rel="noopener noreferrer" class="footer_list_link">Facebook</a>
                                </li>
                                <li>
                                    <a href="{{ route('storefront.products.index') }}" class="footer_list_link">All Products</a>
                                </li>
                                <li>
                                    <a href="{{ route('storefront.checkout.show') }}" class="footer_list_link">Checkout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer_bottom">
        <div class="container">
            <div class="row">
                <div class="col-xxl-6 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                    <div class="footer_copyright">
                        <p>{{ request()->getHost() }}</p>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="footer_develop_by">
                        <p>Developed by</p>
                        <span class="footer_develop_by_link">MIT</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="fixed_footer_menu">
    <ul>
        <li>
            <a href="{{ route('storefront.home') }}" class="fixed_footer_menu_link">
                <i class="fa-solid fa-house"></i>
                <p class="home_text">Home</p>
            </a>
        </li>
        <li>
            <a href="#offcanvasMenuId" data-bs-toggle="offcanvas" class="fixed_footer_menu_link">
                <i class="fa-solid fa-table-cells"></i>
                <p>Category</p>
            </a>
        </li>
        <li>
            <a href="{{ route('storefront.cart.index') }}" class="fixed_footer_menu_link">
                <i class="fa-solid fa-cart-shopping"></i>
                <p>Cart</p>
            </a>
        </li>
        <li>
            <a href="tel:01317448899" class="fixed_footer_menu_link">
                <i class="fa-solid fa-phone"></i>
                <p>Call</p>
            </a>
        </li>
        <li>
            @auth
                <a href="{{ route('dashboard') }}" class="fixed_footer_menu_link">
                    <i class="fa-regular fa-user"></i>
                    <p>Account</p>
                </a>
            @else
                <a href="{{ route('login') }}" class="fixed_footer_menu_link">
                    <i class="fa-regular fa-user"></i>
                    <p>Login</p>
                </a>
            @endauth
        </li>
    </ul>
</div>

<div class="header_mobile_menu offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenuId" aria-labelledby="offcanvasMenuLabel">
    <div class="header_mobile_top">
        <div class="header_mobile_logo">
            <a href="{{ route('storefront.home') }}">
                <img src="{{ asset('brand/multazim_logo.png') }}" alt="{{ config('app.name', 'Multazim') }}">
            </a>
        </div>
        <div class="header_mobile_close_icon" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
    <div class="header_mobile_middle">
        <div class="mobile_main_menu">
            <ul>
                @foreach ($menuItems as $menuItem)
                    <li>
                        <a href="{{ $menuItem['url'] }}" class="mobile_main_menu_link">{{ $menuItem['label'] }}</a>
                    </li>
                @endforeach
                <li>
                    <a href="{{ route('storefront.products.index') }}" class="mobile_main_menu_link">All Products</a>
                </li>
                <li>
                    <a href="{{ route('storefront.cart.index') }}" class="mobile_main_menu_link">Cart</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<a class="fixed_product_sticky" href="{{ route('storefront.cart.index') }}">
    <div class="fixed_product_sticky_icon">
        <i class="fa-solid fa-cart-shopping"></i>
    </div>
    <div class="fixed_product_sticky_price">
        <p>Cart</p>
    </div>
    <div class="fixed_product_sticky_count">
        <p>{{ __('Items') }}</p>
    </div>
</a>

<div id="whatsapp_id" class="fixed_footer_whatsapp_icon" onclick="whatsapp()">
    <span class="whatsapp_close">
        <i class="fa-solid fa-xmark"></i>
    </span>
    <a class="whatsapp_icon" href="https://wa.me/+8801317448899" target="_blank" rel="noopener noreferrer">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    function search() {
        var searchElement = document.getElementById('search_id');
        if (searchElement) {
            searchElement.classList.toggle('search_toggle');
        }
    }

    function whatsapp() {
        var whatsappElement = document.getElementById('whatsapp_id');
        if (whatsappElement) {
            whatsappElement.classList.toggle('whatsapp_toggle');
        }
    }

    (function () {
        var stickyHeader = document.querySelector('.sticky_header');
        if (!stickyHeader) {
            return;
        }

        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                stickyHeader.classList.add('fixed');
            } else {
                stickyHeader.classList.remove('fixed');
            }
        });
    }());

    $(function () {
        $('.slider_banner_active').owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            dots: true,
            nav: true,
            navText: ['<i class="fa-solid fa-angle-left"></i>', '<i class="fa-solid fa-angle-right"></i>']
        });

        $('.product_carousel').owlCarousel({
            loop: true,
            margin: 16,
            autoplay: false,
            dots: false,
            nav: true,
            navText: ['<i class="fa-solid fa-angle-left"></i>', '<i class="fa-solid fa-angle-right"></i>'],
            responsive: {
                0: { items: 1 },
                576: { items: 2 },
                992: { items: 4 }
            }
        });
    });
</script>
</body>
</html>
