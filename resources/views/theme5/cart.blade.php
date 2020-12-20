@extends('theme5.layouts.main')

<style>
    .sub-tot{
        background: #fff;
        padding: 10px;
    }
    .sub-tot li{
        border-bottom: 1px solid lightgrey;
        line-height: 2.5rem;
    }
    .send-gift {
        margin-bottom: 1rem;
    }
    .send-gift a {
      font-weight: 600;
      color: #1d4f82;
    }
    .badge-1 { background-color: #dc3545 !important; }
</style>
@section('content')
    <div class="p-70" style="background: #f3f3f3">

        <div class="container">

            <h4 class="checkout-heading mt-5">Cart</h4>
            <hr class="chk_title_bar">
            <div class="row p-70">

                <div class="col-md-12 col-sm-12">
                    {{-- <div class="cart-ready">
                        <span>Your Cart is Ready</span>
                        <a class="clearcart"><i class="fa fa-return"></i> Return</a>
                        <a href="#" class="clearcart"><i class="fa fa-times"></i> Clear</a>
                    </div> --}}
                    <div class="cart-details-container mt-3">
                        {{-- <div class="store_details pr-3 pl-3">

                        </div> --}}
                        <div class="checkout-items table-responsive">
                            <table class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Qty</th>
                                        <th>Rate</th>
                                        <th>Amount</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if( count( Cart::content() ) )
                                        @foreach( Cart::content() as $item )
                                            <tr>
                                                <td><img width="70" height="70" src="{{ asset('uploads/products/thumbnails/'.$item->model->featuredImage) }}" alt=""></td>
                                                <td><p>{{ ucfirst($item->model->productName) }}</p></td>
                                                <td>
                                                    <div class="" style="display: flex;">
                                                    <form action="{{ route('cart.update', $item->rowId) }}" method="post" class="add-item" >
                                                    {{csrf_field()}}
                                                    {{ method_field('PUT') }}

                                                    <input type="hidden" name="item_count" value="{{ $item->qty-1}}">
                                                    <div class="p-minus">
                                                        <svg class="minus-item" height="35" viewBox="0 0 10 2" width="10">
                                                            <path  d="M0 1.75h10V.25H0z" fill="#fff" fill-rule="nonzero"></path>
                                                        </svg>
                                                    </div>
                                                    <noscript><input type="submit" name="submit"></noscript>
                                                    </form>

                                                    <div class="p-quantity">
                                                        {{-- <p class="p-quantity inputBulkOrderClass total-counts"><span class="">{{ $item->qty }}</span></p> --}}
                                                        <form action="{{ route('cart.update', $item->rowId) }}" method="post" class="submit-form">
                                                            {{csrf_field()}}
                                                            {{ method_field('PUT') }}
                                                            <select name="item_count" class="form-control" style="">
                                                                <?php for ($i=1; $i <= 10; $i++) { ?>
                                                                    <option value="{{$i}}" {{ $item->qty == $i ? 'selected' : '' }}>{{$i}}</option>
                                                                <?php } ?>
                                                            </select>
                                                            <noscript><input type="submit" name="submit"></noscript>
                                                        </form>
                                                    </div>

                                                    <form action="{{ route('cart.update', $item->rowId) }}" method="post" class="add-item" >
                                                        {{csrf_field()}}
                                                        {{ method_field('PUT') }}

                                                    <input type="hidden" name="item_count" value="{{ $item->qty+1}}">
                                                        <div class="p-plus add-item" style="background: #1d4f82;">
                                                            <svg height="9" viewBox="0 0 10 10" width="9">
                                                                <path d="M5.765 10V5.765H10v-1.53H5.765V0h-1.53v4.235H0v1.53H4.235V10z" fill="#FFF" fill-rule="nonzero"></path>
                                                            </svg>
                                                        </div>

                                                        <noscript><input type="submit" name="submit"></noscript>
                                                    </form>
                                                    </div>

                                                </td>
                                                <td>
                                                    <p>NRS. {{ $item->model->rate }}</p>
                                                </td>
                                                <td>
                                                    <p>NRS. {{ $item->model->rate * $item->qty}}</p>
                                                </td>
                                                <td>
                                                    <a class="cart_quantity_delete" href="" onclick="event.preventDefault();document.getElementById('remove-item-{{$item->model->slug}}').submit();"><i class="fa fa-times"></i></a>
                                                        <form id="remove-item-{{$item->model->slug}}" action="{{ route('cart.destroy', $item->rowId) }}" method="post">
                                                            {{csrf_field()}}
                                                            {{ method_field('delete') }}
                                                        </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        <tr class="text-center">
                                            <td colspan="6">No Item Available in your Cart</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>

            </div>

            <div class="row pb-5">
                <div class="col-md-6 pt-3 send-gift">
                @auth
                    <a href="#" class="mt-3" data-toggle="modal" data-target="#giftModal">Want To Send Gift?</a><br/>
                @else
                    <a href="#" class="mt-3" data-toggle="modal" data-target="#giftModal2">Want To Send Gift?</a><br/>
                @endauth
                    <?php $gifts = App\Coupon::orderBy('created_at', 'desc')->where('type', 1)->take('2')->get(); $i=1; ?>
                    <span><small>Try codes:</small></span>
                    @foreach( $gifts as $gift )
                    <span class="badge badge-success badge-{{ $i }}">{{ $gift->couponCode }}</span> <?php $i++; ?>
                    @endforeach
                </div>
            @if( count( Cart::content() ) )
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <ul class="sub-tot" style="padding-left: 3rem;">
                        <li>Cart Sub Total : <span>NRs. {{Cart::subtotal()}}</span></li>
                        <li>Shipping Cost : <span>{{ $rate == 0 ? 'Free' : 'NRs. ' . $rate  }}</span></li>
                    </ul>
                </div>

                <div class="col-md-12 col-sm-12">
                    <a href="{{ url('/show-checkout') }}" class="chk_proceed_pay" style="padding: 15px 0px;">Proceed To Checkout</a>
                    <a href="{{ url('/') }}" class="chk_proceed_pay" style="padding: 15px 0px;">Continue Shopping</a>
                </div>
            @else
                <a href="{{ url('/') }}" class="chk_proceed_pay" style="padding: 15px 0px;">Continue Shopping</a>
            @endif
            </div>

        </div>

    </div>



    {{-- Gift modal --}}
    <!-- Modal -->
    <div class="modal fade" id="giftModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body text-center">
              <span>You need to be logged in to send a gift. <a href="{{ url('/user-login') }}">Follow me</a> </span>
            </div>
          </div>
        </div>
      </div>
    @auth
    <div class="modal fade" id="giftModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Want To Send Gift To Someone?</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6 col-xs-6">
                    <label>Send to Username</label>
                    <input type="text" name="uname" placeholder="Full Name" class="form-control" id="uname">
                </div>

                <div class="col-md-6 col-xs-6">
                    <label>Phone Number</label>
                    <input type="number" name="phone" min="10" max="14" placeholder="Phone" class="form-control" id="uphone">
                </div>
              </div>
              <br/>
              <div class="row">
                <div class="col-md-6 col-xs-6">
                  <label>Coupon Code:</label>
                  <input type="text" name="coupon" id="coupon_code" class="form-control" placeholder="Gift Code">
                </div>
                <div class="col-md-6">
                  <label>&nbsp;</label><br/>
                  <button type="button" class="btn btn-primary" id="confirm_gift" data-sendby="{{ Auth::id() }}">Confirm Sending Gift</button>
                </div>
              </div>
            </div>
            <div class="modal-footer">

            </div>
          </div>
        </div>
      </div>
      @endauth
@endsection

@section('scripts')

<script type="text/javascript">
  $('#confirm_gift').click(function(){

    const uname = $('#uname').val();
    const phone = $('#uphone').val();
    const code = $('#coupon_code').val();
    const sentBy = $(this).data('sendby');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: '{{ url("check/gift/ajax") }}',
        data: {
            uname, phone, code
        },
        success: function(data) {

            if (data.status == 200) {

              let user = data.data;
              let sentTo = user.id;

              if (confirm('Are you sure you want to send this gift code?')) {

                // Send with ajax
                $.ajax({
                    type: 'POST',
                    url: '{{ url("send/gift/ajax") }}',
                    data: {
                        code, sentTo, sentBy
                    },
                    success: function(data1) {

                      if (data1.status == 200) {

                        Swal.fire({
                            title: 'Success!',
                            text: "Succesfully sent the Gift Coupon.",
                            icon: 'success',
                        });

                        location.reload();

                      }

                    }

                  });

              }else{
                location.reload();
              }

            } else if( data.status = 404 ) {

              Swal.fire({
                  text: 'Sorry! The coupon code is not active or you have already used it. Please try again.',
                  icon: 'error',
                  confirmButtonText: 'Ok'
              })

            }else{

              Swal.fire({
                  text: 'Active user with that username not found.',
                  icon: 'error',
                  confirmButtonText: 'Exit'
              })

            }
          }
        });

  });
</script>

@endsection
