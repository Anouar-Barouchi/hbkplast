@extends('public.layout')

@section('title', setting('store_tagline'))

@section('content')
@includeUnless(is_null($slider), 'public.home.sections.slider')
@if (setting('storefront_features_section_enabled'))
<home-features :features="{{ json_encode($features) }}"></home-features>
@endif


@if (setting('storefront_featured_categories_section_enabled'))
<featured-categories :data="{{ json_encode($featuredCategories) }}" @open-modal="openModal"></featured-categories>
@endif


<div class="p-5">
    <div class="swiper-container p-2 d-none">
        <div class="swiper-wrapper">
            @foreach ($categories as $category)
            <div class="swiper-slide">
                <a
                href="{{ route('categories.products.index', ['category' => $category->slug]) }}"
                >
                    @if ($category->logo->path)
                    <img class=" mw-100" src="{{ $category->logo->path }}" alt="">
                    @else
                    <img class=" mw-100" src="{{ asset('image.png') }}" alt="">
                    @endif
                    <span>{{ $category->name }}</span>
                </a>
            </div>
            @endforeach
            
            <!-- Add more slides as needed -->
        </div>
        

        <div class="swiper-pagination"></div>
    </div>
</div>

@if (setting('storefront_three_column_full_width_banners_enabled'))
<banner-three-column-full-width :data="{{ json_encode($threeColumnFullWidthBanners) }}">
</banner-three-column-full-width>
@endif

@if (setting('storefront_product_tabs_1_section_enabled'))
<product-tabs-one :data="{{ json_encode($productTabsOne) }}" @open-modal="openModal"></product-tabs-one>
@endif

@if (setting('storefront_top_brands_section_enabled') && $topBrands->isNotEmpty())
<top-brands :top-brands="{{ json_encode($topBrands) }}"></top-brands>
@endif

@if (setting('storefront_flash_sale_and_vertical_products_section_enabled'))
<flash-sale-and-vertical-products :data="{{ json_encode($flashSaleAndVerticalProducts) }}" @open-modal="openModal">
</flash-sale-and-vertical-products>
@endif

@if (setting('storefront_two_column_banners_enabled'))
<banner-two-column :data="{{ json_encode($twoColumnBanners) }}"></banner-two-column>
@endif

@if (setting('storefront_product_grid_section_enabled'))
<product-grid :data="{{ json_encode($productGrid) }}" @open-modal="openModal"></product-grid>
@endif

@if (setting('storefront_three_column_banners_enabled'))
<banner-three-column :data="{{ json_encode($threeColumnBanners) }}"></banner-three-column>
@endif

@if (setting('storefront_product_tabs_2_section_enabled'))
<product-tabs-two :data="{{ json_encode($tabProductsTwo) }}" @open-modal="openModal"></product-tabs-two>
@endif

@if (setting('storefront_one_column_banner_enabled'))
<banner-one-column :banner="{{ json_encode($oneColumnBanner) }}"></banner-one-column>
@endif

<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-3">
                {{-- <img :src="modalProductImage" alt="Product Image" class="modal-product-image">
                <h3 v-html="name"></h3>
                <input type="number" v-model="quantity" class="modal-quantity-input">
                <button @click="addToCart(product)" class="btn btn-primary modal-add-to-cart">Add to Cart</button> --}}


                <div >
                    <div class="product-card-top">
                        <a class="product-image">
                                <img :src=" modalProductImage" :class="{ 'image-placeholder': !modalProductImage }"
                            alt="product image">
                        </a>
                        <ul class="list-inline product-badge">
                            <li class="badge badge-success" v-if="product.has_percentage_special_price"
                                v-html="product.special_price_percent">
                            </li>
                        </ul>
                    </div>

                    <div class="m-4">

                        <div>
                            <h6 v-html="product.name"></h6>
                        </div>
                        <div class="form-group m-3">
                            <input type="number" v-model="quantity" :step="product.unit" v-bind:min="product.unit" class="form-control">
                        </div>
                        <div class="product-price" v-html="product.formatted_price"></div>
                    </div>

                    <div class="">

                        <button class="btn btn-primary w-100" @click="addToCart(product)">
                            <i class="las la-cart-arrow-down"></i>
                            {{ trans('storefront::product_card.add_to_cart') }}
                        </button>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection