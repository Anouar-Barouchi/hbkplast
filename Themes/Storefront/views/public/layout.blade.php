<!DOCTYPE html>
<html lang="{{ locale() }}">

<head>
    <base href="{{ config('app.url') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>
        @hasSection('title')
        @yield('title') - {{ setting('store_name') }}
        @else
        {{ setting('store_name') }}
        @endif
    </title>

    @stack('meta')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" /><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Swiper CSS -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/swiper/swiper-bundle.min.css"
    />

    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500&display=swap" rel="stylesheet">

    @if (is_rtl())
    <link rel="stylesheet" href="{{ v(Theme::url('public/css/app.rtl.css')) }}">
    @else
    <link rel="stylesheet" href="{{ v(Theme::url('public/css/app.css')) }}">
    @endif

    <link rel="shortcut icon" href="{{ $favicon }}" type="image/x-icon">

    @stack('styles')
    <style>
        .swiper-slide {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    </style>

    {!! setting('custom_header_assets') !!}

    <script>
        window.FleetCart = {
            baseUrl: '{{ config('app.url') }}',
            rtl: {{ is_rtl() ? 'true' : 'false' }},
            storeName: '{{ setting('store_name') }}',
            storeLogo: '{{ $logo }}',
            loggedIn: {{ auth()->check() ? 'true' : 'false' }},
            csrfToken: '{{ csrf_token() }}',
            stripePublishableKey: '{{ setting('stripe_publishable_key') }}',
            razorpayKeyId: '{{ setting('razorpay_key_id') }}',
            cart: {!! $cart !!},
            wishlist: {!! $wishlist !!},
            compareList: {!! $compareList !!},
            langs: {
                'storefront::layout.next': '{{ trans('storefront::layout.next') }}',
                'storefront::layout.prev': '{{ trans('storefront::layout.prev') }}',
                'storefront::layout.search_for_products': '{{ trans('storefront::layout.search_for_products') }}',
                'storefront::layout.all_categories': '{{ trans('storefront::layout.all_categories') }}',
                'storefront::layout.most_searched': '{{ trans('storefront::layout.most_searched') }}',
                'storefront::layout.search_for_products': '{{ trans('storefront::layout.search_for_products') }}',
                'storefront::layout.category_suggestions': '{{ trans('storefront::layout.category_suggestions') }}',
                'storefront::layout.product_suggestions': '{{ trans('storefront::layout.product_suggestions') }}',
                'storefront::layout.product_suggestions': '{{ trans('storefront::layout.product_suggestions') }}',
                'storefront::layout.more_results': '{{ trans('storefront::layout.more_results') }}',
                'storefront::product_card.out_of_stock': '{{ trans('storefront::product_card.out_of_stock') }}',
                'storefront::product_card.new': '{{ trans('storefront::product_card.new') }}',
                'storefront::product_card.add_to_cart': '{{ trans('storefront::product_card.add_to_cart') }}',
                'storefront::product_card.view_options': '{{ trans('storefront::product_card.view_options') }}',
                'storefront::product_card.compare': '{{ trans('storefront::product_card.compare') }}',
                'storefront::product_card.wishlist': '{{ trans('storefront::product_card.wishlist') }}',
                'storefront::product_card.available': '{{ trans('storefront::product_card.available') }}',
                'storefront::product_card.sold': '{{ trans('storefront::product_card.sold') }}',
                'storefront::product_card.years': '{{ trans('storefront::product_card.years') }}',
                'storefront::product_card.months': '{{ trans('storefront::product_card.months') }}',
                'storefront::product_card.weeks': '{{ trans('storefront::product_card.weeks') }}',
                'storefront::product_card.days': '{{ trans('storefront::product_card.days') }}',
                'storefront::product_card.hours': '{{ trans('storefront::product_card.hours') }}',
                'storefront::product_card.minutes': '{{ trans('storefront::product_card.minutes') }}',
                'storefront::product_card.seconds': '{{ trans('storefront::product_card.seconds') }}'
            },
        };
    </script>

    {!! $schemaMarkup->toScript() !!}

    @stack('globals')

    @routes
</head>

<body class="page-template {{ is_rtl() ? 'rtl' : 'ltr' }}" data-theme-color="#{{ $themeColor->getHex() }}" style="--color-primary: #{{ $themeColor->getHex() }};
            --color-primary-hover: #{{ $themeColor->darken(8) }};
            --color-primary-transparent: {{ color2rgba($themeColor, 0.8) }};
            --color-primary-transparent-lite: {{ color2rgba($themeColor, 0.3) }};">
    <div class="wrapper" id="app">
        @include('public.layout.top_nav')
        @include('public.layout.header')
        @include('public.layout.navigation')
        @include('public.layout.breadcrumb')



        @yield('content')

        @include('public.home.sections.subscribe')
        @include('public.layout.footer')

        <div class="overlay"></div>
        <product-modal></product-modal>
        @include('public.layout.sidebar_menu')
        @include('public.layout.sidebar_cart')
        @include('public.layout.alert')
        @include('public.layout.newsletter_popup')
        @include('public.layout.cookie_bar')
        
    </div>

    <script>
        window.Laravel = {!! json_encode([
            'isUserLoggedIn' => Auth::check(),
        ]) !!};
    </script>

    @stack('pre-scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script src="{{ v(Theme::url('public/js/app.js')) }}"></script>

    @stack('scripts')
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var swiper = new Swiper('.swiper-container', {
                loop: true,
                slidesPerView: 5,
                spaceBetween: 30,
                
                // Enable navigation
                navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
                },

                breakpoints: {
                    // when window width is >= 320px
                    320: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    // when window width is >= 480px
                    480: {
                        slidesPerView: 4,
                        spaceBetween: 30
                    },
                    // when window width is >= 640px
                    640: {
                        slidesPerView: 6,
                        spaceBetween: 40
                    }
                },
                
                autoplay: {
                    delay: 1000, // Delay in milliseconds between slides
                    disableOnInteraction: true, // Autoplay will not be disabled after user interactions
                },
    
            });

            $('.swiper-container').removeClass('d-none');

        });
      </script>

    {!! setting('custom_footer_assets') !!}
</body>

</html>