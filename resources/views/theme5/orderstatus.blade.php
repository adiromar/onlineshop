@extends('theme5.layouts.main')

@section("styles")

<style media="screen">
    .p-70 { background-color: whitesmoke; }
    .order-wrapper { background-color: white;padding: 2rem 2rem;border-radius: 12px; margin-top: 1rem; }
    .order-no {     background-color: #f2f2f2;padding: 10px 20px;width: 95%;border-radius: 10px; }
    .order-no span { color: #1d4f82; }
    .order-date { padding: 10px;color: #ccc; }
    .p2 { padding: 2rem 2rem; }
    .title { color: #868e96; }
    .subtitle { color: #f5b100; font-size: 20px; }
    .delivery-date { color: #000; font-weight: 700; font-size: 22px; }
    .product-title a { color: #1d4f82; }
    .cancel-order {
      border: 2px solid #c5b4b4;
      padding: 5px 30px;
      margin-right: 1rem;
      color: #000;
    }
    .main-title h2 { display: inline; }
    .main-title small { color: grey; margin-left: 20px; }
</style>

@endsection

@section('content')

  <div class="p-70">
    <div class="container pt-4 pb-4">
      <div class="row">
        <div class="col-md-12 main-title">
          <h2>My Orders</h2>
          <small>View and edit all your Pending Orders.</small>
        </div>
      </div>

      @if( count($orders) > 0 )
      @foreach( $orders as $order )
      <section class="order-wrapper">

        <div class="row">
          <div class="col-md-4">
            <div class="order-no">
              Order No: <span>#{{ $order->unique_order_identifier }}</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="order-date">
              <span>Order placed on: {{ date("l, F d 'y", strtotime($order->created_at)) }}</span>
            </div>
          </div>
        </div>

        <?php
            $details = DB::table('order_details')->select(['productName', 'slug', 'categoryId', 'categoryName', 'featuredImage', 'order_details.rate', 'order_details.quantity'])
                        ->where('order_id', $order->id)
                        ->join('products', 'products.id', '=', 'order_details.product_id')
                        ->get();
            $i = 0;
            $price = 0;
        ?>

        @foreach( $details as $detail )
        <div class="row p2">
          <div class="col-md-2">
            <img src="{{ asset('uploads/products/thumbnails/' . $detail->featuredImage) }}" alt="" width="80" height="90">
          </div>
          <div class="col-md-3">
            <ul>
              <li class="product-title"> <h4><a href="{{ route('view.product.new5', $detail->slug) }}">{{ $detail->productName }}</a></h4> </li>
              <li>Qty: <small>{{ $detail->quantity }}</small></li>
              <li>NRs. {{ $detail->rate }}</li>
            </ul>
          </div>
          <div class="col-md-4">
          @if( $i == 0 )
            <ul>
              <li class="title">STATUS:</li>
              <li class="subtitle">@if( $order->order_status == 1 ) Pending Confirmation @elseif( $order->order_status == 2 ) Forwarded to Shipping @endif </li>
            </ul>
          @endif
          </div>
          <div class="col-md-3">
          <?php $next = date('Y-m-d', strtotime($order->created_at . ' + 5 days')); ?>
          @if( $i == 0 )
            <ul>
              <li class="title">EXPECTED DELIVERY BY:</li>
              <li class="delivery-date">{{ date("d F 'y ", strtotime($next)) }}</li>
            </ul>
          @endif
          </div>
        </div>
        <?php $price = $price + $detail->rate; ?>
        <?php $i++; ?>
        @endforeach
        <div class="row">
          <div class="col-md-3">
            <form id="cancel-{{ $order->id }}" action="{{ route('cancel.user.order') }}" method="post">
              {{ csrf_field() }}
              <input type="hidden" name="orderStatus" value="0">
              <input type="hidden" name="orderId" value="{{ $order->id }}">
              <a href="#" type="submit" class="cancel-order" data-cls="cancel-{{ $order->id }}">Cancel Order</a>
            </form>
          </div>
          <div class="col-md-4">
            <span class="title">Payment method: Cash on Delivery</span><br/>
          </div>
          <div class="col-md-2">
            <span>Shipping Cost: {{ $order->shippingCost == 0 ? 'Free' : 'NRs. ' . $order->shippingCost }}</span>
          </div>
          <div class="col-md-3">
            <b class="delivery-date">Total Order: {{ $order->shippingCost == 0 ? $price : ($price + $order->shippingCost) }}/- </b>
          </div>
        </div>
      </section>
      @endforeach
      @else
        <section class="order-wrapper">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-body">
                      <div class="card-text">
                          There are no pending orders.
                      </div>
                  </div>
              </div>
          </div>
        </section>
      @endif
    </div>
  </div>

@endsection

@section('scripts')

<script type="text/javascript">
  $('.cancel-order').click(function(){
    let mid = $(this).data('cls');
    if ( confirm("Are you sure you want to cancel this order? Click ok to proceed.") ) {
      $('#'+mid).submit();
    }else{
      alert('Request not confirmed!');
    }
  });
</script>

@endsection
