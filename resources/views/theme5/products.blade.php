@extends('theme5.layouts.main')

{{-- @yield('modals') --}}
<style>
.card-product__title a{
    font-size: 18px !important;
}
.card-product__del{
    color: red;
    font-size: 14px;
}
/* .card-product__imgOverlay li button {
background: #ff742c !important;
}
.card-product__imgOverlay li:hover{
    background: #603ff1 !important;
} */
.card-product__imgOverlay li button:hover {
    background: #ff8f55 !important;
}
</style>
<link rel="stylesheet" href="{{ asset('themes/5/vendors/themify-icons/themify-icons.css') }}">
<link rel="stylesheet" href="{{ asset('themes/5/vendors/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('themes/5/vendors/css/style.css') }}">


@section('content')
    <div class="p-70">

        <div class="bg-img">
            <div class="containermain">


                @php
                    // $slides = App\Sliders::latest()->where('showSlider', 1)->get()->take(6);
                @endphp

                {{-- <div class="owl-main owl-carousel owl-theme">
                    <div class="item"><img src="{{ asset('/' . $cat->image) }}" alt="" style="object-fit: none !important;"></div>
                </div> --}}

                <div class="category-pg show-banner">
                    @if ($cat->banner)
                    <img src="{{ asset('/' . $cat->banner) }}" alt="" style="width: 100%;" >
                    @else
                    <img src="{{ asset('themes/5/img/Banner-category.jpg') }}" alt="" style="width: 100%;" >
                    @endif

                </div>

            </div>
        </div>

        <div class="container pt-4 pb-4">

                <div class="slick-main" style="height: fit-content;">

                    {{-- @if( $category = App\Category::latest()->get() ) --}}
                    @if( $parentcategories )
                    @foreach ($parentcategories as $cat)
                        <div class="slider-div text-center">
                        <a href="{{ route('category.product.new5', $cat->slug) }}"><img src="{{ asset('/' . $cat->image) }}" class="filter-catt" data-cat_id="{{ $cat->id }}"></a>
                            <div class="nameDiv"><span>{{ ucfirst($cat->name) }}</span></div>
                        </div>
                    @endforeach

                    @else

                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/burger.png') }}">
                        <div class="nameDiv"><span>No Categories</span></div>
                    </div>

                    @endif
                </div>

                <div class="row mt-5" id="vendor-data">
                    <div class="col-12 col-lg-12 mb-4">
                        <h4 class="text-center">{{ $catname->name }}</h4>
                        <hr class="chk_title_bar">
                    </div>

                    <div class="col-md-12">
                    <div class="filter-bar d-flex flex-wrap align-items-center">
                        <div class="sorting mr-auto">
                            <h6><span style="color: blue">{{ count($products) }}</span> products found</h6>
                        </div>
                        <div class="sorting">
                            <select class="nic-select sort-product" name="sort">
                                <option value="name">Sort By Name <i class="fa fa-chevron-down"></i></option>
                                <option value="low_high" {{ request()->sort == 'low_high' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="high_low" {{ request()->sort == 'high_low' ? 'selected' : '' }}>Price: High to Low</option>
                            </select>
                        </div>
                      </div>
                    </div>

                    @if(count($products) > 0 )
                        @foreach ($products as $product)

                        <div class="col-md-3 col-xs-6 mb-4">
                            <div class="single-product">
                            <div class="product-img">
                                <a href="#">
                                    <a href="{{ route('view.product.new5', $product->slug) }}"><img class="default-img" src="{{ asset('uploads/products/thumbnails/' . $product->featuredImage) }}" alt="#"></a>
                                    {{-- <img class="hover-img" src="https://via.placeholder.com/550x750" alt="#"> --}}

                                </a>
                                <div class="abs-btn">
                                    @if( $product->rate < $product->actualRate )
                                    <span class="sale">Sale</span>
                                    @endif

                                    @php
                                    $ww = 0;
                                    if ( Auth::user() ) {
                                    $userid = Auth::id();

                                    $check = App\Wishlist::where('userId', $userid)->where('productId', $product->id)->first();
                                        if($check){
                                            if($check->deleted == 0){
                                                $ww = 1;
                                            }
                                        }else{
                                            $ww = 0;
                                        }
                                    }
                                    @endphp

                                    @if($ww == 1)
                                    <span class="wishlist add-to-wishlist" data-product="{{ $product->id }}"><i class="fa fa-heart active"></i></span>
                                    @else
                                    <span class="wishlist add-to-wishlist" data-product="{{ $product->id }}"><i class="fa fa-heart"></i></span>
                                    @endif
                                </div>
                            </div>
                            <div class="product-content">
                            <h3><a href="{{ route('view.product.new5', $product->slug) }}">{{ mb_strimwidth($product->productName, 0, 26, "...") }}</a></h3>
                                <div class="product-price bold">
                                <span class="old">NRS.{{ $product->rate }}</span>
                                    <span class="addcart">
                                        <button class="btn btn-default btn-sm cart-btn add-to-cart" data-productid="{{$product->id}}" data-product="{{ $product->productName }}" data-rate="{{ $product->rate }}">Add To Cart</button>
                                    </span>
                                </div>

                            </div>
                        </div>
                        </div>


                        @endforeach
                    @else


                    <div class="col-12 col-lg-12">
                        <p class="text-center">No Products Available</p>
                    </div>

                    @endif


                </div>

                {{-- <ul class="pagination ss"> --}}
                    {{ $products->links() }}
                {{-- </ul> --}}

        </div>
    </div>

    <script src="{{ asset('themes/5/js/jquery/jquery-2.2.4.min.js') }}"></script>
    <script>
        $( window ).on( "load", function() {
            // $( "#vendor-data" ).scroll();
            $('.slick-arrow').html('');
            $('html, body').animate({scrollTop: '545px'}, 800);
        });
    </script>
@endsection
