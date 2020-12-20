@extends('theme5.layouts.main')

@section ('meta')
<meta property="og:title" content="{{ $product->productName }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ route('view.product.new55', $product->id) }}" />
<meta property="og:image" content="{{ $product->featuredImage }}" />

<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="{{ route('view.product.new55', $product->id) }}">
<meta name="twitter:title" content="{{ $product->productName }}">
<style>
    .main-wrapper {
        padding: 8rem 8rem;
        background-color: #f3f3f3;
        height: auto;
        position: relative;
    }
    .breadcrumbs li, .sizes li, .prices ul li {
        display: inline;
    }
    .categories-wrapper {
        padding: 8px 10px;
        background-color: white;
        border-radius: 6px;
        width: 130px;
        font-weight: 600;
        color: #1d4f82;
    }
    
    .categories-wrapper a {
        font-weight: 600;
        color: #1d4f82;   
    }
    .breadcrumbs {
        margin-top: 1rem;
        margin-bottom: 1rem;
        font-size: 16px;
    }
    .breadcrumbs li a {
        color: grey;
    }
    .thumb-list img {
        margin-bottom: 10px;
    }
    .thumb-list .active img {
        border: 2px solid darkgrey;
        border-radius: 5px;
    }
    .main-image img {
        width: 100%;
        height: 380px;
        border-radius: 5px;
        object-fit: cover;
    }
    .product-wrapper .discount {
        position: relative;
        margin-top: 1rem;
        margin-bottom: 4rem;
    }
    .prices {
        padding-top: 1rem;
    }
    .overlap-2 {
        background-color: #28a745;
        color: white;
        padding: 4px 6px;
        font-size: 13px;
        position: absolute;
        font-weight: 600;
        width: 75px;
    }
    .overlap-2 .pointer {
        top: 0px;
        left: 75px;
        position: absolute;
    }
    .overlap {
        background-color: #28a745;
        color: white;
        padding: 4px 6px;
        font-size: 13px;
        font-weight: 600;
    }
    .main-image .overlap {
        position: absolute;
        top: 15px;
        width: 70px;
    }
    .product-wrapper .overlap {
        position: relative;
        width: 100%;
    }
    .pointer {
        width: 0;
        height: 0;
        border-top: 15.4px solid transparent;
        border-left: 15px solid #28a745;
        border-bottom: 12px solid transparent;
    }
    .main-image .pointer{
        position: absolute;
        top: 0px;
        left: 70px;
    }
    .product-wrapper {
        padding-right: 4rem;
    }
    .product-wrapper .cat {
        display: block;
        font-size: 14px;
    }
    .product-wrapper .cat .right {
        float: right;
        color: green
    }
    .product-wrapper .cat .left {
        float: left;
        color: grey
    }
    .product-wrapper .title {
        clear: both;
        font-size: 26px;
        font-weight: 600;
    }
    .sizes, .buttons {
        margin-top: 1rem;
    }
    .sizes label {
        font-size: 17px;
        color: grey;
        font-weight: 600;
    }
    .sizes ul li {
        padding: 4px 15px;
        background-color: #d4d9de;
        color: #1d4f82;
        border-radius: 5px;
        margin-right: 15px;
        font-weight: 600;
        font-size: 13px;
    }
    .sizes ul li.xs {
        padding: 4px 10px;
    }
    .sizes ul li.active {
        background-color: white;
        border: 1px solid whitesmoke;
        color: #1d4f82;
    }
    .clearfix { clear: both }
    .float-left {
        float: left;
    }
    .float-right {
        float: right;
    }
    .prices ul {
        display: flex;
        flex-wrap: nowrap;
    }
    .prices .mrp {
        margin-right: 2rem;
        flex: 0 1 40%;
    }
    .prices .price {
        flex: 0 1 40%
    }
    .ml {
        margin-left: 2rem;
    }
    .prices span {
        font-size: 19px;
    }
    .prices .price small {
        display: block;
        font-size: 13px;
    }
    .buttons .add-to-cart {
        background-color: #1d4f82;
        color: white;
        font-size: 14px;
        padding: 7px 40px;
        border-radius: 6px;
        margin-right: 1rem;
        border: 1px solid #1d4f82;
    }
    .buttons .add-to-cart:hover {
        border: 2px solid #1d4f82;
        background-color: whitesmoke;
        color: #1d4f82;
        font-weight: 600;
    }
    .buttons .add-to-wishlist {
        margin-left: 1rem;
        background-color: whitesmoke;
        font-size: 14px;
        padding: 7px 38px;
        border-radius: 6px;
        color: #1d4f82;
        border: 2px solid #1d4f82;
        font-weight: 600;
    }
    .buttons .add-to-wishlist:hover {
        background-color: #1d4f82;
        color: white
    }
    .reviews-wrapper h3 {
        font-size: 22px
    }
    .reviewer {
        font-weight: 600;
        margin-top: 12px;
    }
    .reviews-wrapper {
        margin-top: 3.5rem;
    }
    .product-details {
        margin-top: 1rem;
    }
    .product-details .heading {
       color: #1d4f82;
       font-weight: 600;
       font-size: 20px;
       margin-bottom: 10px;
    }
    .product-details .desc {
      margin-top: 2rem;
    }
    .title {
        color: #1d4f82;
    }
    .def-color, .def-color a {
        color: #1d4f82 !important; 
    }
    .stars .fa-star{
        color: lightgrey;
        font-size: 12px;
    }
    .product-wrapper .btn-review {
        background-color: #1d4f82;
        color: white;
        cursor: pointer;
        padding: 3px 15px;
    }
    .warranty, .stock {
        font-size: 14px;
        padding: 5px 0px;
    }
    .font-15 {
        font-size: 15px !important;
    }
    .add-review {
        background-color: white;
        padding: 1rem 2rem;
        margin-top: 2rem;
    }
    .product-wrapper .review-form input, .product-wrapper .review-form textarea {
        border: 1px solid rgb(29 79 130);
        padding-left: 10px;
    }
    .review {
        border-bottom: 2px solid #d1d9e1;
        margin-bottom: 1rem;
    }
    .related-products {
        background-color:white;
        padding: 2rem 0.5rem;
        margin-top:2rem;
    }
    .related-products .owl-nav {
        margin: 0;
        position: absolute;
        top: 50%;
        width: 100%;
        margin-top: -25px;
    }
    .related-products .owl-carousel .owl-nav .owl-prev {
        left: 0;
    }
    .related-products .owl-carousel .owl-nav .owl-next {
        right: 0;
        float: right;
    }
    .category-list {
        display:none;
        background-color: white;
        padding: 2rem;
        position: absolute;
        width: 300px;
        z-index: 10;
        left: 135px;
        top: 0px;
        border-radius: 5px;
    }
    .related-products .heading {
        font-size: 35px;
        margin-bottom: 2rem;
        margin-left: -18px;
    }
    .related-products {
        background-color: white;
        padding: 3rem 10rem;
        margin-top: 2rem;
    }
    .single-product .product-img a img {
        height: 160px !important;
    }
    .single-product-new {
        padding: 1.5rem;
        border: 1px solid #dedede;
    }
    .single-product-new .default-img {
        padding: 20px;
    }
    .product-content h3 {
        line-height: 20px;
        height: 45px;
    }
    .product-content h3 a {
        color: #1d4f82;
        font-size: 15px;
        font-weight: 700;
        text-transform: capitalize;
    }
    .single-product-new .product-content h3 a:hover {
        color:  #f4b100;
    }
    .single-product-new .addcart .cart-btn {
        padding: 3px 5px;
    }
    .single-product-new .product-price {
        margin-top: 5px;
    }
    .single-product-new .product-img .abs-btn .sale {
        background-color: #f4b100;
        font-size: 13px;
        color: #201f1f;
        padding: 3.5px 16px;
        font-weight: 700;
        text-align: center;
        text-transform: uppercase;
        position: absolute;
        top: 19px;
        left: 15px;
        border-radius: 15px;
    }
    .single-product-new .product-img .abs-btn span.wishlist {
        font-size: 22px;
        color: #c0c6cc;
        right: 0px;
        top: 19px;
        padding: 1px 16px;
        font-weight: 700;
        border-radius: 0;
        text-align: center;
        position: absolute;
        text-transform: uppercase;
        height: 26px;
        cursor: pointer;
    }
    .single-product-new .product-img .abs-btn span.wishlist .active {
        color: #1d4f82;
    }
    .cart-btn.add-to-cart:hover {
        border: 1.5px solid #1d4f82;
        background-color: whitesmoke;
        color: #1d4f82;
        font-weight: 600;
    }
    .single-product-new .old {
        font-weight: 500;
    }
    .no-carousel .single-product {
        margin-right: 10px;
    }
    .bold {
        font-weight: 600;
    }
    .hide {
        display: none;
    }
    .shop-name {
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
    .shop-name span {
        font-weight: 400;
    }
    .view-more {
        font-size: 15px;
    }
    .shortDesc {
        margin-bottom: 1rem;
    }
    .view-more-wrapper {
        padding-top: 0.6rem;
    }
    .bg-white {
        background-color: white;
        padding: 15px 15px;
    }
    .owl-carousel.owl-loaded {
        position: relative;
    }
    .owl-carousel.owl-loaded .owl-nav {
        position: absolute;
        top: 45%;
    }
    .related-products .owl-carousel .owl-nav .owl-prev,
    .related-products .owl-carousel .owl-nav .owl-next {
        padding: 6px 10px 4px 8px !important;
        background-color: white;
        border-radius: 50%;
        box-shadow: 1px 2px 10px 3px #d2b1b1;
    }
    .related-products .owl-carousel .owl-nav .owl-prev {
        margin-left: -15px;
    }
    .related-products .owl-carousel .owl-nav .owl-next {
        margin-right: -15px;
    }
    @media only screen and (min-width: 768px) and (max-width: 991px) {
        .containers .main-wrapper {
            padding: 6rem 3rem;
        }
        .product-wrapper .title {
            font-size: 23px;
        }
        .prices ul {
            display: block;
        }
        .prices .mrp, .prices .price {
            display: block;
            margin: 0;
            margin-bottom: 5px;
        }
        .buttons .add-to-cart,
        .buttons .add-to-wishlist {
            display: block;
            margin: 0;
            margin-top: 10px;
            width: 70%;
            text-align: center;
        }
        .main-image img {
            height: 320px;
        }
        .related-products {
            padding: 2rem 5rem;
            margin-top: 0;
        }
        .related-products .single-product .product-content {
            margin-top: 0;
        }
        .related-products .addcart .cart-btn {
            font-size: 12px;
        }
        .product-content h3 {
            height: 70px;
        }
    }
    @media only screen and (max-width: 480px) {
        .containers .main-wrapper {
            padding: 6rem 2rem;
        }
        .buttons .add-to-cart,
        .buttons .add-to-wishlist {
            display: block;
            margin: 0;
            margin-top: 10px;
            width: 70%;
            text-align: center;
        }
        .thumb-list .thumbs {
            width: 80px;
            margin-right: 5px; 
        }
        .product-wrapper {
            padding: 1rem;
            border: 1px solid #1d4f82;
            border-radius: 5px;
            margin-top: 1rem;
        }
        .prices ul {
            display: block;
        }
        .prices .mrp, .prices .price {
            display: block;
            margin: 0;
            margin-bottom: 5px;
        }
        #fancyNav {
            width: 125%;
        }
        .related-products {
            padding: 1rem;
        }
        .related-products .heading {
            margin-left: 0px;
        }
        .related-products .owl-carousel.owl-loaded {
            padding: 1px 20px;
        }
        .related-products .single-product, .related-products .single-product-new {
            margin-right: 5px;
            margin-left: 5px;
            padding-bottom: 40px;
            padding-right: 20px;
            flex: 0 1 45%;
        }
        .main-image img {
            height: 320px;
        }
        .category-list {
            left: 0px;
            top: 45px;
        }
        .owl-carousel.owl-drag .owl-item {
            width: 145px;
        }
        .related-products .owl-carousel .owl-nav .owl-next {
            margin-right: -3px;
        }
        .single-product .product-img .abs-btn .sale {
            padding: 3px 10px !important;
            font-size: 11px !important;
        }
        .single-product .product-content h3 a {
            font-size: 14px;
        }
        .single-product .product-content h3 {
            line-height: 12px;
            height: 30px;
        }
        .single-product .old {
            font-size: 14px;
        }
        .owl-stage .owl-item.active {
            margin-right: 0px !important;
        }
    }
</style>

@endsection


@section('content')

<div class="p-70s">

<div class="containers">
<div class="row p-70s">
<div class="main-wrapper bg-img">
<div class="h-100 bg-img">
    <div class="top-section" style="position: relative;">
        <div class="categories-wrapper">
            <a href=""><span>Categories</span></a>&nbsp;<i class="fa fa-caret-right"></i>
        </div>
        <div id="category-list" class="category-list">
            <ul>
            @if( $category = App\Category::where('parentId', 0)->orderBy('name')->latest()->get() )
            @foreach( $category as $cat )
                <li class="cat def-color bm-1">
                    <a href="{{ route('category.product.new5', $cat->slug) }}">{{ ucfirst($cat->name) }}</a>
                </li>
            @endforeach
            @endif
            </ul>
        </div>
    </div>
    

    <div class="breadcrumbs">
        <ul>
            <li><a href="{{ url('/') }}">HOME</a> &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></li>
            @if( isset($parent) )
            <li><a href="{{ route('category.product.new5', $parent->slug) }}">{{ ucfirst($parent->name) }}</a> &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></li>
            @endif
            <li><a href="{{ route('category.product.new5', $product->category->slug) }}">{{ ucfirst($product->category->name) }}</a> &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i></li>
            <li><span style="color: grey;">{{ ucfirst($product->productName) }}</span></li>
        </ul>
    </div>

    <div class="row">
    <!-- row-left -->
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-3">
                <div class="thumb-list">

                    <a class="active thumb-list-item" href="#">
                        <img class="thumbs" data-src="{{  asset('uploads/products/'.$product->featuredImage) }}" src="{{  asset('uploads/products/thumbnails/'.$product->featuredImage) }}" alt="">
                    </a>
                @foreach( $product->images()->get()->take(2) as $img )
                    <a href="#" class="thumb-list-item">
                        <img class="thumbs" src="{{ asset('uploads/products/thumbnails/'.$img->image) }}" alt="" data-src="{{ asset('uploads/products/'.$img->image) }}">
                    </a>
                @endforeach

                </div>
            </div>
            <div class="col-md-9">
                <div class="main-image">
            @if ( $layout == 'other' )
                @if( $product->discountPercent && ($product->discountPercent <= 100) )
                    <span class="overlap">{{ $product->discountPercent }} Off<div class="pointer"></div></span>
                @endif
            @endif
                <div class="img-append" style="border-radius: 5px">
                    <img src="{{  asset('uploads/products/'.$product->featuredImage) }}" alt="">
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php $bck = ''; ?>
                @if( $layout == 'other' )
                <?php $bck = 'bg-white'; ?>
                @endif
                <div class="product-details {{ $bck }}">
                    <div class="heading">PRODUCT DETAILS</div>
                    <div class="shortDesc font-15">
                      {{ $product->shortDesc}}
                    </div>

                    @if( $product->warranty == 1 )
                    <div class="warranty">
                        Upto {{ $product->warrantyPeriod }} <b>Warranty</b>
                    </div>
                    @endif

                    @if ( $layout == 'default' )
                    @if( $shop_name )
                    <div class="shop-name bold">Seller: <span>{{$shop_name}}</span></div>
                    @endif
                    @endif
                    
<!-- View More -->

    @if( $layout == 'default' )
        @if ( $product->description )
            <a href="" class="view-more title bold">View More</a>
            <div class="view-more-wrapper hide">
                <div class="font-15">
                  {!! $product->description !!}
                </div>
            </div>
        @endif
    @endif

<!-- endof View more -->
<!-- Specifications -->
    
    @if( $layout == 'other' )             
        @if ( $product->description )
            <div class="desc">
              <div class="heading">
                Specifications:
              </div>
              <div class="font-15">
                  {!! $product->description !!}
              </div>
            </div>
        @endif
    @endif

<!-- endOf Specifications -->

                </div><!-- end of product details -->
            </div>
        </div>
    </div>
    <!-- row right -->
    <div class="col-md-6">
        <div class="product-wrapper">

        <div class="row">
            <div class="col-md-12">
            @if ( $layout == 'other' )
            <div class="cat">
                <div class="left">
                    @if( $shop_name )
                    {{ ucfirst( $shop_name ) }}
                    @endif
                </div>
                <div class="right">
                @if( $product->availableItems < 4 )
                    {{ $product->availableItems }} items in Stock
                @else
                    In stock
                @endif
                </div>
            </div>
            @endif 
            </div>
        
            
            <div class="col-md-12">
                <h2 class="title" style="text-align: justify;">{{ ucfirst($product->productName) }}</h2>
            </div>

            <div class="col-md-12">
                @if ( $layout == 'default' )
                <p style="color: green;">
                    @if( $product->availableItems < 4 )
                        {{ $product->availableItems }} items in Stock
                    @else
                        In stock
                    @endif
                </p>
                @endif
            </div>
            
            @if( $product->ltr )
            <div class="col-md-12">
                
                <div class="sizes">
                    <ul>
                        <li class="xs {{ $product->ltr == '500ml' ? 'active' : '' }}">500 ml</li>
                        <li class="{{ $product->ltr == '1l' ? 'active' : '' }}">1L</li>
                        <li class="{{ $product->ltr == '2l' ? 'active' : '' }}">2L</li>
                    </ul>
                </div>
                
            </div>
            @endif   

            @if( $product->discountPercent )
            <div class="col-md-12">
            
                @if ( $layout == 'default' )
                <div class="discount">
                    @if( $product->discountPercent <= 100 )
                        <span class="overlap-2">{{ $product->discountPercent }} Off<div class="pointer"></div></span>
                    @endif
                </div>
                @endif  
            
            </div>
            @endif    
            
            @if( $product->size )
            <div class="col-md-12">
                
                <div class="sizes">
                    <label>Size:</label>
                    <ul>
                        <li class="xs {{ $product->size == 'xs' ? 'active' : '' }}">XS</li>
                        <li class="{{ $product->size == 's' ? 'active' : '' }}">S</li>
                        <li class="{{ $product->size == 'm' ? 'active' : '' }}">M</li>
                        <li class="{{ $product->size == 'l' ? 'active' : '' }}">L</li>
                        <li>+3</li>
                    </ul>
                </div>
                
            </div>
            @endif

            <div class="col-md-12">
                <div class="prices">
                    <ul>
                    <?php $class = ''; ?>
                    @if ($product->actualRate - $product->rate > 0)
                        <li class="mrp"><span><strong>MRP:</strong></span>
                            <span style="text-decoration: line-through;">&nbsp;Rs. {{ $product->actualRate }}</span>
                        </li>
                    <?php $class = 'ml'; ?>
                    @endif
                        <li class="price {{ $class }}">
                            <span><strong>Price:</strong>&nbsp;Rs. {{ $product->rate }}<small>(Inclusive of all taxes)</small></span>
                            
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="buttons">
                    <a href="" class="add-to-cart" data-productid="{{$product->id}}" data-product="{{ $product->productName }}" data-rate="{{ $product->rate }}">Add to Cart</a>
                    <a href="" class="add-to-wishlist" data-product="{{$product->id}}">Add to Wishlist</a>
                </div>    
            </div>
    
            <div class="col-md-12">
                <div class="reviews-wrapper">
                    <h3>Ratings & Reviews ({{ $product->reviews()->count() }})</h3>
                    <ul class="review-list">
                    @foreach($product->reviews()->latest()->get()->take(3) as $review)
                        <li class="review">
                            <div class="reviewer">{{ ucfirst($review->user->username) }}</div>
                            @if( $review->rating )
                            <div class="stars">
                                <i class="{{ $review->rating >= 1 ? 'def-color' : '' }} fa fa-star"></i>
                                <i class="{{ $review->rating >= 2 ? 'def-color' : '' }} fa fa-star"></i>
                                <i class="{{ $review->rating >= 3 ? 'def-color' : '' }} fa fa-star"></i>
                                <i class="{{ $review->rating >= 4 ? 'def-color' : '' }} fa fa-star"></i>
                                <i class="{{ $review->rating >= 5 ? 'def-color' : '' }} fa fa-star"></i>
                            </div>
                            @endif
                            <p style="color: black !important;font-size: 15px;">{{ $review->reviewDesc }}</p>
                        </li>
                    @endforeach
                    </ul>
                </div>    
            </div>            

            <div class="col-md-12">
                @auth
            <div class="add-review">
                <h4 class="title" style="font-size: 18px">Add a Review</h4>

                <form action="{{ route('product.review') }}" method="post" class="review-form">
                      {{csrf_field()}}
                    
                    <div class="aa-your-rating">
                         <div class="form-group" id="rating" style="display: inline-flex;">
                            <small>Rate this product&nbsp;&nbsp;</small>
                        </div>
                    </div>
                    
                    <!-- <div class="form-group"> -->
                        <!-- <label for="name">Review Title <span class="req">*</span></label> -->
                        <input type="hidden" class="" name="reviewTitle" id="name" value="Review" placeholder="Title" required>
                    <!-- </div> -->
                
                    <div class="form-group">
                        <label for="">Your Review <span class="req">*</span></label>
                        <textarea class="" name="reviewDesc" rows="2" id="message"></textarea>
                    </div>

                    
                    <input type="hidden" name="user_id" value="{{Auth::id()}}">
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <input type="hidden" name="email" value="{{Auth::user()->email}}">
                    <button type="submit" class="btn btn-default btn-review">
                        Submit
                    </button>
                    
                </form>

            </div>
            @endauth
            </div>

        </div>
        </div>
    </div>
    </div>

    


</div>
</div>
</div>
</div>
</div>

@if( count( $productsOfCategory ) )
<div class="row single-page">
        <div class="col-md-12">

        <div class="related-products">
            <div class="heading">Related Products</div>    
            <div class="row {{ count( $productsOfCategory ) > 3 ? 'owl-carousel' : 'no-carousel'}} popular-slider">
                @foreach ($productsOfCategory as $product)
                
            
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

            @endforeach

            </div>            
        </div>
            
        </div>
    </div>
@endif

@endsection

@section('scripts')
    <script src="{{ asset('js/jquery.emojiRatings.min.js') }}"></script>
    <script type="text/javascript">

        $("#rating").emojiRating({
            fontSize: 20,
            onUpdate: function(count) {
                $(".review-text").show();
                $("#starCount").html(count + " Star");
                var rating = $('.emoji-rating').val();
                $('#rating-input').val(rating);
            }
        });


        $('.thumb-list .thumbs').click(function(e){
            e.preventDefault();
            let src = $(this).data('src');
            $(".thumb-list-item").removeClass('active');
            $(this).closest('a').addClass('active');
            $('.img-append').html(`<img src="${src}" alt="Product Image">`);
        });

        $('#order-submit').click(function(e){
            $(this).prop('disabled', true);
            $('#oform').submit();
        });

        $('.categories-wrapper a').on('mouseover click', function(e){
            e.preventDefault();
            $('#category-list').show();
        });
        $('#category-list').on('mouseleave click', function(e){
            $(this).hide();
        });

        $('.view-more').click(function(e){
            e.preventDefault();
            $('.view-more-wrapper').toggleClass('hide');
        });
    </script>

@endsection
