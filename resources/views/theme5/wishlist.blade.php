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

    .card-product__imgOverlay li button:hover {
        background: #ff8f55 !important;
    }
    </style>
    <link rel="stylesheet" href="{{ asset('themes/5/vendors/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/5/vendors/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/5/vendors/css/style.css') }}">

@section('content')
    <div class="p-70">

        <div class="container pt-4 pb-4">


                <div class="row mt-5" id="vendor-data">
                    <div class="col-12 col-lg-12 mb-4">
                        <h4 class="text-center">{{ $title }}</h4>
                        <hr class="chk_title_bar">
                    </div>

                    @if(count($products) > 0 )
                        @foreach ($products as $product)

                        <div class="col-md-3 mb-4 col-xs-6">
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
                    {{-- <div class="col-lg-4 col-md-12 mb-3">
                        <div class="card card-main">
                            <div class="card-inner">
                                <div class="card-image">
                                    <img src="{{ asset('themes/5/img/ansari.jpg') }}" class="card-image-view">

                                    <p class="closed-tag">Closed</p>
                                </div>
                                <div class="card-right">
                                    <div class="card-heading">
                                        <span>Bombay Halal..</span>
                                    </div>
                                    <div class="card-info">

                                    </div>
                                    <div class="card-description">
                                        <p>No Rating Yet</p>
                                    </div>

                                    <div class="viewmenu">
                                        <a href="">View Menu <i class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-12 col-lg-12">
                        <p class="text-center">No Products Available</p>
                    </div>

                    @endif

                </div>

        </div>
    </div>


@endsection
