@extends('theme5.layouts.main')

{{-- @yield('modals') --}}


@section('content')
@php
    $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $store_id = array_pop($uriSegments);

@endphp
    <div class="p-70s">

        <div class="containers">
            <div class="row p-70s">


                <div class="fancy-breadcumb-area bg-img" style="background-color: #f3f3f3;padding: 75px 0px;min-height: 650px;height: auto;">
                    <div class="h-100 bg-img" style="">
                     <div class="row">
                         <div class="col-lg-12 col-sm-12">
                             <div class="bannerDiv" style="background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.27)), url({{ asset($supplier->image) }});">
                                 <div class="inner-search-div">
                                     <div class="heading_cvr">
                                         <div class="name">
                                             <span>{{ $supplier->detail }}</span>
                 
                                             <div class="customRatingDiv">
                                                 <span class="ratingCount">Rate Now</span>
                                             </div>
                                         </div>
                 
                                         <div class="addressDetail displayFlex mt-4">
                                             <div class="displayFlex">
                                                 <i class="fa fa-map-marker"></i>
                                                 <div> {{ $supplier->address }}</div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                 
                                 <div class="storelogo">
                                     <img src="{{ asset($supplier->image) }}" class="storelogobend">
                                 </div>
                             </div>
                 
                             <div class="prodsearch">
                                 <div class="container">
                                     <div class="row">
                                         <div class="col-lg-10 col-md-10 search-bar">
                                             <form action="" style="width: 100% !important;">
                                                 <div class="input-group">
                                                     <input type="text" class="form-control" placeholder="Search Product">
                                                     <span class="input-group-addon bg-white"><i class="fa fa-search"></i></span>
                                                 </div>                                
                                             </form>
                                         </div>
                                     </div>
                                 </div>
                                 
                             </div>
                 
                 
                             
                 
                 
                         </div>
                     </div>
                 
                     <!-- item list -->
                     <div class="container">
                         <div class="row">
                             <div class="col-lg-3 col-12 menu-cat-list">
                                 <div class="cat-heading bg-white">
                                     <span>Menu</span>
                                 </div>
                                 <div class="menu-list">
                                     <div class="menu-list-li">

                                            <div class="deskview active">
                                                <span class="filter-cat-menu" data-cat_id="{{ $cat->id }}" data-storeid="{{ $store_id}}">{{ $cat->name }}</span>
                                            </div>

                                        @if(count($categories) > 0)

                                            @foreach ($categories as $category)
                                            <div class="deskview">
                                            <span class="filter-cat-menu" data-cat_id="{{ $category->id }}" data-storeid="{{ $store_id}}">{{ $category->name }}</span>
                                            </div>
                                        @endforeach
                                        @else
                                            <div class="deskview">
                                                <span>-</span>
                                            </div>
                                        @endif

                                        
                                         
                                     </div>
                                 </div>
                             </div>
                 
                             <div class="col-lg-9 col-12" style="display: flex;width: 100%;">
                                 <div class="product-app">
                                     <div class="productlayout">
                                         <div class="cat-heading">
                                             <span class="category_head">{{ $cat->name }}</span>
                                         </div>
                 
                                         @if(count($products) > 0)
                                         @foreach ($products as $product)

                                         <div class='container-lz loading' style="display: none;">
                                            <div class='img-container'>
                                              <div class='img'>
                                              </div>
                                            </div>
                                            <div class='content'>
                                              <div class='stripe small-stripe'>
                                              </div>
                                              <div class='stripe medium-stripe'>
                                              </div>
                                              <div class='stripe long-stripe'>
                                              </div>
                                            </div>
                                          </div>

                                         <div class="itemProduct">
                                             <div class="itemDetailDiv">
                                                 <div class="p-detail-section">
                                                     <div class="">
                                                     <p>{{ strtoupper($product->productName) }}</p>
                                                     </div>
                                                     <div class="p-action-btn">
                                                         <div class="" style="display: flex;">
                                                             <div class="p-minus">
                                                                 <svg height="7" viewBox="0 0 10 2" width="10"><path  d="M0 1.75h10V.25H0z" fill="#858585" fill-rule="nonzero"></path></svg>
                                                             </div>
                                                             <div class="p-quantity">
                                                                 <input appnumberonly="" aria-label="Product quantity" class="p-quantity inputBulkOrderClass ng-untouched ng-pristine ng-valid" maxlength="4" style="visibility: visible;">
                                                             </div>
                                                             <div class="p-plus add-to-cart" style="background: rgb(5, 5, 5);" data-hh="here" data-productid="{{$product->id}}" data-product="{{ $product->productName }}" data-rate="{{ $product->rate }}">
                                                                 <svg height="9" viewBox="0 0 10 10" width="9"><path d="M5.765 10V5.765H10v-1.53H5.765V0h-1.53v4.235H0v1.53H4.235V10z" fill="#FFF" fill-rule="nonzero"></path></svg>
                                                             </div>
                                                         </div>
                                                     </div>
                                                     
                                                 </div>
                 
                                                 <div class="p-description">
                                                     <span>{{ $product->shortDesc }}</span>
                                                 </div>
                                                 <div class="price-box">
                                                     <p><b>NRS. {{ $product->rate }}</b></p>
                                                 </div>
                                             </div>
                                         </div>

                                         

                                          
                                         @endforeach
                                         @else

                                         

                                         <div class="itemProduct">
                                             <div class="itemDetailDiv">
                                                 <div class="p-detail-section">
                                                     <div class="">
                                                         <p>No Data Found</p>
                                                     </div>
                                                     <div class="p-action-btn">
                                                         <div class="" style="display: flex;">
                                                             {{-- <div class="p-minus">
                                                                 <svg height="7" viewBox="0 0 10 2" width="10"><path  d="M0 1.75h10V.25H0z" fill="#858585" fill-rule="nonzero"></path></svg>
                                                             </div> --}}
                                                             {{-- <div class="p-quantity">
                                                                 <input appnumberonly="" aria-label="Product quantity" class="p-quantity inputBulkOrderClass ng-untouched ng-pristine ng-valid" maxlength="4" style="visibility: visible;">
                                                             </div>
                                                             <div class="p-plus" style="background: rgb(5, 5, 5);">
                                                                 <svg height="9" viewBox="0 0 10 10" width="9"><path d="M5.765 10V5.765H10v-1.53H5.765V0h-1.53v4.235H0v1.53H4.235V10z" fill="#FFF" fill-rule="nonzero"></path></svg>
                                                             </div> --}}
                                                         </div>
                                                     </div>
                                                     
                                                 </div>
                 
                                                 <div class="p-description">
                                                     <span>Service Time: 23 unit</span>
                                                 </div>
                                                 <div class="price-box">
                                                     <p><b>NRS. 40.00</b></p>
                                                 </div>
                                             </div>
                                         </div>

                                         @endif
                 
                 
                                     </div>
                                 </div>
                                 <div class="cart-app">
                                     <div class="cat-heading bg-white">
                                         <span>Cart</span>
                                     </div>

                                     @if( count( Cart::content() ) )
                                        @foreach( Cart::content() as $item )

                                        <div class="app-cart-div">

                                            


                                            <div class="CartItem">
                                                <p>{{ ucfirst($item->model->productName) }}</p>

                                                <div class="cart-action-btn">
                                                    <div class="" style="display: flex;">
                                                        <div class="p-minus">
                                                            {{-- <svg height="7" viewBox="0 0 10 2" width="10"><path  d="M0 1.75h10V.25H0z" fill="#858585" fill-rule="nonzero"> --}}
                                                                <a class="cart_quantity_delete" href="" onclick="event.preventDefault();document.getElementById('remove-item-{{$item->model->slug}}').submit();"><i class="fa fa-minus"></i></a>
                                                                <form id="remove-item-{{$item->model->slug}}" action="{{ route('cart.destroy', $item->rowId) }}" method="post">
                                                                    {{csrf_field()}}
                                                                    {{ method_field('delete') }}
                                                                </form>    
                                                            {{-- </path></svg> --}}
                                                        </div>
                                                        <div class="p-quantity">
                                                            <input appnumberonly="" aria-label="Product quantity" class="p-quantity inputBulkOrderClass ng-untouched ng-pristine ng-valid" maxlength="4" style="visibility: visible;" value="1">
                                                        </div>
                                                        <div class="p-plus" style="background: rgb(5, 5, 5);">
                                                            <svg height="9" viewBox="0 0 10 10" width="9"><path d="M5.765 10V5.765H10v-1.53H5.765V0h-1.53v4.235H0v1.53H4.235V10z" fill="#FFF" fill-rule="nonzero"></path></svg>
                                                        </div>
                                                        <div class="cart-price ml-5">
                                                        <p>NRS. {{ $item->model->rate * $item->qty}}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
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
@endsection