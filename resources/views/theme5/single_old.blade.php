@extends('theme5.layouts.main')

{{-- @yield('modals') --}}


@section('content')

    <div class="p-70s">

        <div class="containers">
            <div class="row p-70s">


                <div class="fancy-breadcumb-area bg-img" style="background-color: #f3f3f3;padding: 75px 0px;min-height: 650px;height: auto;">
                    <div class="h-100 bg-img" style="">
                     {{-- <div class="row">
                         <div class="col-lg-12 col-sm-12">
                             <div class="bannerDiv" style="background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.27)), url({{  asset('uploads/products/'.$product->featuredImage) }});">
                                 <div class="inner-search-div">
                                     <div class="heading_cvr">
                                         <div class="name">
                                             <span>{{ $product->productName }}</span>
                 
                                             <div class="customRatingDiv">
                                                 <span class="ratingCount">Rate Now</span>
                                             </div>
                                         </div>
                 
                                         <div class="addressDetail displayFlex mt-4">
                                             <div class="displayFlex">
                                                 <i class="fa fa-map-marker"></i>
                                                 <div> {{ $product->categoryName }}</div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                 
                                 <div class="storelogo mb-5">
                                     
                                     <img src="{{ asset($supplier->image) }}" class="storelogobend" alt="no image">
                                 </div>
                             </div>
                 
                         </div>
                     </div> --}}
                 
                     <!-- item list -->
                     <div class="container mt-5">
                         <div class="row">
                            
                 
                             <div class="col-lg-12 col-12" style="display: flex;width: 100%;">
                                 <div class="product-app">
                                     <div class="productlayout">
                                         {{-- <div class="cat-heading">
                                             <span class="category_head">{{ $product->productName }}</span>
                                         </div> --}}
                 

                                         <div class="itemProduct">
                                             <div class="itemDetailDiv">
                                                 <div class="p-detail-section">
                                                     <div class="col-lg-12 col-12 row">
                                                        <div class="col-lg-5 col-12">
                                                            <img src="{{  asset('uploads/products/'.$product->featuredImage) }}" alt="" />
                                                         </div>

                                                         <div class="col-lg-7 col-12">
                                                            <div class="catt-heading">
                                                                <h4 class="single_head">{{ $product->productName }}</span>
                                                                
                                                            </div>
                                                            <div class="review mb-3">
                                                                {{-- <span>0 Reviews</span> --}}
                                                                <p>{{ $product->reviews()->count() }} Review(s)</p>
                                                                    <style>
                                                                        .yellow{ color: orange }
                                                                    </style>
                                                                    @if( $averageRating > 0 )
                                                                    <i class="{{ $averageRating >= 1 ? 'yellow' : '' }} fa fa-star"></i>
                                                                    <i class="{{ $averageRating >= 2 ? 'yellow' : '' }} fa fa-star"></i>
                                                                    <i class="{{ $averageRating >= 3 ? 'yellow' : '' }} fa fa-star"></i>
                                                                    <i class="{{ $averageRating >= 4 ? 'yellow' : '' }} fa fa-star"></i>
                                                                    <i class="{{ $averageRating >= 5 ? 'yellow' : '' }} fa fa-star"></i>
                                                                    @endif
                                                            </div>
                                                            <div class="price-sec">
                                                                <span>NRS. {{ $product->rate }}</span>
                                                                @if ($product->actualRate - $product->rate > 0)
                                                                    <del>NRS. {{ $product->actualRate }}</del>
                                                                @else
                                                                     {{-- nothing --}}
                                                                @endif
                                                                
                                                            </div>
                                                            <div class="cart-sec mb-3" style="overflow: hidden">
                                                                <a href="" class="p-plus-c text-white add-to-cart" data-productid="{{$product->id}}" data-product="{{ $product->productName }}" data-rate="{{ $product->rate }}">+</a>
                                                            </div>
                                                            <div class="desc">
                                                                <p>{{ $product->shortDesc }}</p>
                                                            </div>
                                                            <div class="desc">
                                                                <p>Availability: In Stock</p>
                                                            </div>
                                                            <div class="desc">
                                                            <p>Category: {{ $product->category->name }}</p>
                                                            </div>

                                                            

                                                         </div>
                                                     </div>
                                                     
                                                     
                                                     
                                                 </div>
                 
                                             </div>
                                         </div>

                                     </div>

                                     <div class="productlayout mt-5">
                                        <div class="itemProduct">
                                            <div class="col-md-12">
                                                
                                                <p><b>Write Your Review</b></p>
                                                <form action="{{ route('product.review') }}" method="post" class="pl-2">
                                                      {{csrf_field()}}
                                                    
                                                    <div class="aa-your-rating">
                                                         <div class="form-group" id="rating" style="display: inline-flex;">
                                                            <small>Rate this product&nbsp;&nbsp;</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="name">Review Title</label>
                                                        <input type="text" class="form-control" name="reviewTitle" id="name" placeholder="Name">
                                                    </div>
                                                
                                                    <div class="form-group">
                                                        <label for="">Your Review</label>
                                                        <textarea class="form-control" name="reviewDesc" rows="3" id="message"></textarea>
                                                    </div>

                                                    @auth
                                                    <input type="hidden" name="user_id" value="{{Auth::id()}}">
                                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                                    <input type="hidden" name="email" value="{{Auth::user()->email}}">
                                                    <button type="submit" class="btn btn-primary pull-right">
                                                        Submit
                                                    </button>
                                                    @endauth
                                                    @guest
                                                    {{-- <button type="" class="btn btn-primary pull-right">
                                                        Login To Write Review
                                                    </button> --}}
                                                <a href="{{ url('/login_new') }}" class="btn btn-primary pull-right">Login To Write Review</a>
                                                    @endguest
                                                    
                                                </form>
                                            </div>
                                        </div>
                                     </div>
                                 </div>
                                 <div class="cart-app">
                                     <div class="cat-heading bg-white">
                                         <span>Cart</span>
                                     </div>

                                     {{-- @php
                                         dd(Cart::content());
                                     @endphp --}}
                                     @if( count( Cart::content() ) )
                                        @foreach( Cart::content() as $item )

                                        <div class="app-cart-div">

                                            


                                            <div class="CartItem">
                                                <div class="row">
                                                    <div class="cart-pro-image col-md-3">
                                                        <img width="35" height="35" src="{{ asset('uploads/products/thumbnails/'.$item->model->featuredImage) }}" alt="">
                                                    </div>
                                                    <div class="col-md-9">
                                                        <p>{{ ucfirst($item->model->productName) }}</p>
                                                    </div>
                                                </div>
                                                

                                                <div class="cart-action-btn">
                                                    <div class="" style="display: flex;">

                                                        <form action="{{ route('cart.update', $item->rowId) }}" method="post" class="add-item" >
                                                            {{csrf_field()}}
                                                            {{ method_field('PUT') }}
                                                            
                                                        <input type="hidden" name="item_count" value="{{ $item->qty-1}}">
                                                        <div class="p-minus">
                                                            <svg class="minus-item" height="7" viewBox="0 0 10 2" width="10"><path  d="M0 1.75h10V.25H0z" fill="#858585" fill-rule="nonzero">   
                                                            </path></svg>
                                                        </div>
                                                        <noscript><input type="submit" name="submit"></noscript>
                                                        </form>

                                                        <div class="p-quantity">
                                                            {{-- <input class="p-quantity inputBulkOrderClass total-count" value="1"> --}}
                                                            <p class="p-quantity inputBulkOrderClass total-counts"><span class="">{{ $item->qty }}</span></p>
                                                        </div>

                                                        <form action="{{ route('cart.update', $item->rowId) }}" method="post" class="add-item" >
                                                            {{csrf_field()}}
                                                            {{ method_field('PUT') }}
                                                            
                                                        <input type="hidden" name="item_count" value="{{ $item->qty+1}}">
                                                            <div class="p-plus add-item" style="background: rgb(5, 5, 5);">
                                                                <svg height="9" viewBox="0 0 10 10" width="9">
                                                                    <path d="M5.765 10V5.765H10v-1.53H5.765V0h-1.53v4.235H0v1.53H4.235V10z" fill="#FFF" fill-rule="nonzero"></path>
                                                                </svg>
                                                            </div>

                                                            <noscript><input type="submit" name="submit"></noscript>
                                                        </form>


                                                        {{-- <div class="p-plus add-item" style="background: rgb(5, 5, 5);">
                                                            <svg  height="9" viewBox="0 0 10 10" width="9">
                                                                <path d="M5.765 10V5.765H10v-1.53H5.765V0h-1.53v4.235H0v1.53H4.235V10z" fill="#FFF" fill-rule="nonzero"></path>
                                                            </svg>
                                                        </div> --}}
                                                        <div class="cart-price ml-5">
                                                        <p>NRS. {{ $item->model->rate * $item->qty}}</p>
                                                        </div>
                                                        <div class="ml-4 float-right">
                                                            <a class="cart_quantity_delete" href="" onclick="event.preventDefault();document.getElementById('remove-item-{{$item->model->slug}}').submit();"><i class="fa fa-times"></i></a>
                                                                <form id="remove-item-{{$item->model->slug}}" action="{{ route('cart.destroy', $item->rowId) }}" method="post">
                                                                    {{csrf_field()}}
                                                                    {{ method_field('delete') }}
                                                                </form> 
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <hr>
                                        </div>
                                        
                                        @endforeach


                                    <button class="checkout-button"><a href="{{ url('/show-checkout') }}" class="text-white">Checkout</a></button>
                                        


                                    @else
                                     <div class="app-cart-div pad-60">
                                         <div class="emptyCart">
                                             <span><img src="{{ asset('themes/5/img/empty-cart.svg') }}" alt="Cart Empty" height="70" width="70"></span>
                                             <span class="text-cart">Your Cart is empty</span>
                                             <span class="text-sub-cart">Add an Item to begin</span>
                                         </div>
                                     </div>
                                     @endif

                                 </div>
                             </div>
                             
                         </div>
                     </div>
                     
                 
                     <!-- item list ends1 -->
                 
                 
                    </div>
                 </div>


            </div>
        </div>
    </div>

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
    
    
                $('#order-submit').click(function(e){
                    $(this).prop('disabled', true);
                    $('#oform').submit();
                });
    </script>
    
@endsection