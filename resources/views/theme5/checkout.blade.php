@extends('theme5.layouts.main')

{{-- @yield('modals') --}}
{{-- <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk=" crossorigin="anonymous"></script> --}}
  
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  {{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
  {{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
<style>
    .sub-tot{
        background: #fff;
        padding: 10px;
    }
    .sub-tot li{
        /* background: #fff; */
        /* padding: 5px; */
        border-bottom: 1px solid lightgrey;
        line-height: 2.5rem;
    }
    .link {
        color: #1d4f82;
        font-weight: 600;
    }
    .link:hover {
        color: #000;
    }
    .edit {
        color: #ad1b1b;
        font-size: 14px;
        padding-top: 1rem;
    }
    .ship_detail {
      font-size: 13px;
    }

  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 5px 10px;
  }
</style>
@section('content')
    <div class="p-70" style="background: #f3f3f3">
        <?php $shippingdetail = NULL; ?>
        @auth
       <?php
            $shippingdetail = DB::table('shipping_details')->where('customer_id', Auth::id())->where('active', 1)->first();
        ?>
        @endauth


        <form class="forms" action="{{ route('checkout.newstore') }}" method="POST" id="main-forms" autocomplete="off">
        {{ csrf_field() }}


        <div class="container">

            <h4 class="checkout-heading mt-5">Checkout</h4>
            <hr class="chk_title_bar">
            @include('errors.errors')
            <div class="row p-70">

                <div class="col-md-8 col-sm-12 bg-white p-3">
                    <h4>Delivery Details:</h4>
                    @if( $shippingdetail )
                        <small>You can change your default saved shipping address from the right & Proceed to Order</small>
                    @endif
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Full Name <span class="req">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="full_name" class="form_cont col-12" placeholder="Full Name" value="{{ $shippingdetail ? $shippingdetail->client_name : '' }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Email <span class="req">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" name="user_email" class="form_cont col-12" placeholder="Email" value="{{ $shippingdetail ? $shippingdetail->email : '' }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Shipping Address <span class="req">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="shippingAddress" class="form_cont col-12" placeholder="Address" value="{{ $shippingdetail ? $shippingdetail->address : '' }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="alias">Alias (nearby place):</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="near_by_places" placeholder="*near by places, school, or any popular places" class="form_cont col-12" value="{{ $shippingdetail ? $shippingdetail->near_by_places : '' }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>State/Province <span class="req">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <select name="state" id="state" class="form_cont col-12">
                                        <option value="">Select Province</option>
                                        <option value="1" {{ $shippingdetail && $shippingdetail->state == 1 ? 'selected' : '' }}>Province 1</option>
                                        <option value="2" {{ $shippingdetail && $shippingdetail->state == 2 ? 'selected' : '' }}>Province 2</option>
                                        <option value="3" {{ $shippingdetail && $shippingdetail->state == 3 ? 'selected' : '' }}>Bagmati Province</option>
                                        <option value="4" {{ $shippingdetail && $shippingdetail->state == 4 ? 'selected' : '' }}>Gandaki</option>
                                        <option value="5" {{ $shippingdetail && $shippingdetail->state == 5 ? 'selected' : '' }}>Province 5</option>
                                        <option value="6" {{ $shippingdetail && $shippingdetail->state == 6 ? 'selected' : '' }}>Karnali</option>
                                        <option value="7" {{ $shippingdetail && $shippingdetail->state == 7 ? 'selected' : '' }}>Sudurpaschim</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label for="city">City <span class="req">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="city" class="form_cont col-12" placeholder="City" value="{{ $shippingdetail ? $shippingdetail->city : '' }}" id="city" >
                                    {{-- <datalist id="citylists">
                                      <option value="Kathmandu">
                                      <option value="Lalitpur">
                                      <option value="Bhaktapur">
                                    </datalist> --}}
                                    {{-- <select id="combobox">
                                        <option value="Kathmandu">Kathmandu</option>
                                        <option value="lalitpur">Lalitpur</option>
                                        <option value="bhaktapur">Bhaktapur</option>
                                    </select> --}}

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <select name="city_select" id="sel_city" class="form-cont col-12">
                                                <option value="">Select City</option>
                                                <option value="kathmandu">Kathmandu</option>
                                                <option value="lalitpur">Lalitpur</option>
                                                <option value="bhaktapur">Bhaktapur</option>
                                                <option value="others">Mention if Others</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-cont col-12 city_input" placeholder="City" name="city" value="{{ $shippingdetail ? $shippingdetail->city : '' }}">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Phone Number <span class="req">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="phoneNumber" class="form_cont col-12" placeholder="Phone Number" value="{{ $shippingdetail ? $shippingdetail->phone : '' }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Alternate Phone Number <span class="req"></span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="alternatePhone" class="form_cont col-12" placeholder="" value="{{ $shippingdetail ? $shippingdetail->alternatePhone : '' }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Zipcode <span class="req"></span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="zipcode" class="form_cont col-12" placeholder="Zipcode" value="{{ $shippingdetail ? $shippingdetail->zipcode : '' }}">
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="cart-ready">
                        {{-- <span>Your Cart is Ready</span> --}}
                    <a href="{{ url('/show-cart')}}" class="clearcart"><i class="fa fa-shopping-cart"></i> Return To Cart</a>
                        {{-- <a href="#" class="clearcart"><i class="fa fa-times"></i> Clear</a> --}}
                    </div>
                    <div class="cart-details-container mt-3">
                        <div class="store_details pr-3 pl-3">
                        @auth

                            <div class="row">
                                <div class="col-md-8">
                                    <span><strong>Saved Shipping Details</strong></span>
                                </div>
                                @if( $shippingdetail )
                                <div class="col-md-1">
                                    <input type="hidden" name="saved_shipping_detail" value="{{ $shippingdetail->shipping_details_id }}" style="width: 30px;height: 30px;cursor: pointer">
                                </div>
                                <div class="col-md-9">
                                    <ul class="ship_detail">
                                        <li>{{ $shippingdetail->client_name }}</li>
                                        <li>{{ $shippingdetail->email }}</li>
                                        <li>{{ $shippingdetail->address }}</li>
                                        <li>{{ $shippingdetail->near_by_places ? 'Alias: ' . $shippingdetail->near_by_places : '' }}</li>
                                        <li>{{ $shippingdetail->phone }}</li>
                                        <li>{{ $shippingdetail->city }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('user.shipping.details', Auth::id() ) }}" class="edit">Edit</a>
                                    <span class="badge badge-info">Default</span>
                                </div>
                                @else
                                <div class="col-md-12">
                                    <p>Have not set your shipping details yet? <a href="{{ route('user.shipping.details', Auth::id() ) }}" class="link">Follow here</a></p>
                                </div>
                                @endif
                            </div>

                        @endauth
                        </div>
                        <div class="checkout-items">
                            @if( count( Cart::content() ) )
                                        @foreach( Cart::content() as $item )

                                        <div class="app-cart-div">

                                            <div class="CartItem">
                                                <div class="row">
                                                    <div class="cart-pro-image col-md-3 col-12">
                                                        <img width="35" height="35" src="{{ asset('uploads/products/thumbnails/'.$item->model->featuredImage) }}" alt="">
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <p>{{ ucfirst($item->model->productName) }}</p>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <p>NRS. {{ $item->model->rate * $item->qty}}</p>
                                                    </div>
                                                </div>


                                                <div class="cart-action-btn">
                                                    <div class="" style="display: flex;">

                                                        {{-- <form action="{{ route('cart.update', $item->rowId) }}" method="post" class="add-item" >
                                                            {{csrf_field()}}
                                                            {{ method_field('PUT') }}

                                                        <input type="hidden" name="item_count" value="{{ $item->qty-1}}">
                                                        <div class="p-minus">
                                                            <svg class="minus-item" height="7" viewBox="0 0 10 2" width="10"><path  d="M0 1.75h10V.25H0z" fill="#858585" fill-rule="nonzero">
                                                            </path></svg>
                                                        </div>
                                                        <noscript><input type="submit" name="submit"></noscript>
                                                        </form> --}}

                                                        {{-- <div class="p-quantity">
                                                            <p class="p-quantity inputBulkOrderClass total-counts"><span class="">{{ $item->qty }}</span></p>
                                                        </div> --}}

                                                        {{-- <form action="{{ route('cart.update', $item->rowId) }}" method="post" class="add-item" >
                                                            {{csrf_field()}}
                                                            {{ method_field('PUT') }}

                                                        <input type="hidden" name="item_count" value="{{ $item->qty+1}}">
                                                            <div class="p-plus add-item" style="background: rgb(5, 5, 5);">
                                                                <svg height="9" viewBox="0 0 10 10" width="9">
                                                                    <path d="M5.765 10V5.765H10v-1.53H5.765V0h-1.53v4.235H0v1.53H4.235V10z" fill="#FFF" fill-rule="nonzero"></path>
                                                                </svg>
                                                            </div>

                                                            <noscript><input type="submit" name="submit"></noscript>
                                                        </form> --}}

                                                        {{-- <div class="cart-price ml-5">
                                                        <p>NRS. {{ $item->model->rate * $item->qty}}</p>
                                                        </div> --}}
                                                        <div class="ml-4 float-right">
                                                            {{-- <a class="cart_quantity_delete" href="" onclick="event.preventDefault();document.getElementById('remove-item-{{$item->model->slug}}').submit();"><i class="fa fa-times"></i></a>
                                                                <form id="remove-item-{{$item->model->slug}}" action="{{ route('cart.destroy', $item->rowId) }}" method="post">
                                                                    {{csrf_field()}}
                                                                    {{ method_field('delete') }}
                                                                </form>  --}}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <input type="hidden" name="product_id[]" value="{{ $item->model->id }}">
                                        <input type="hidden" name="rate[]" value="{{ $item->model->rate }}">
                                        <input type="hidden" name="supplier_id[]" value="{{ $item->model->user_id }}">
                                        <input type="hidden" name="quantities[]" value="{{ $item->qty }}">

                                        @endforeach
                                        @endif
                        </div>

                        <div class="row">
                            @if( count( Cart::content() ) )
                                <div class="col-md-12 col-12">
                                    <ul class="sub-tot">
                                        <li>Cart Sub Total : <span class="float-right">NRs. {{Cart::subtotal()}}</span></li>
                                        <li>Shipping Cost : <span class="float-right">{{ $rate == 0 ? 'Free' : 'NRs. ' . $rate  }}</span></li>
                                        <li><strong>Total :</strong> <span class="float-right">
                                          @if( $rate > 0 )
                                          <?php $subtotal = str_replace(',', '', Cart::subtotal()); echo 'NRs. ' . ($subtotal + $rate) . '/-'; ?>
                                          @else
                                            {{ 'NRs. ' . Cart::subtotal() . '/-' }}
                                          @endif
                                        </span></li>
                                    </ul>
                                </div>

                                <div class="col-md-12 col-12">
                                    <input type="hidden" name="shippingCost" value="{{ $rate }}">
                                </div>
                            @else
                                <a href="{{ url('/') }}" class="chk_proceed_pay" style="padding: 15px 0px;">Continue Shopping</a>
                            @endif
                            </div>

                    </div>
                </div>

            </div>


                @if(Auth::user())
                    <input type="hidden" name="username" value="{{ Auth::user()->username }}">
                    <input type="hidden" name="orderedBy" value="{{ Auth::user()->id }}">
                @else
                    <input type="hidden" name="username" value="Guest">
                    <input type="hidden" name="orderedBy" value="">
                @endif

            <input type="hidden" name="payment_method" value="cod">
            <input type="submit" name="btnsubmit" value="Proceed To Order" class="chk_proceed_pay">

        </div>
    </form>
    </div>



  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="{{ asset('themes/5/js/jquery/jquery-2.2.4.min.js') }}"></script>

    <script>
//   $( function() {
//     var availableTags = [
//       "Kathmandu",
//       "Lalitpur",
//       "Bhaktapur",
//     ];
//     $( "#city" ).autocomplete({
//       source: availableTags
//     });
//   } );


  $(document).ready(function(){
    $('#sel_city').change( function() {
        city = this.value;

        if(city == 'kathmandu' || city == 'lalitpur' || city == 'bhaktapur'){
            $('.city_input').hide();
        }else if(city == 'others'){
            // $('#sel_city').prop('disabled', 'disabled');
            $('.city_input').show();
        }else{
            //
        }   
    // alert( city );
    });
});
  </script>

    
@endsection
