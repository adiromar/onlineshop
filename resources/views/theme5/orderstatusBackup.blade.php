@extends('theme5.layouts.main')

@section('content')
    <div class="p-70">
    
        <div class="container pt-4 pb-4">
                <style>
                    .card-title .left {
                        float: left;
                    }
                    .card-title .right {
                        float: right;
                    }
                    .block {
                        margin-top: 2rem;
                        margin-bottom: 4rem;
                    }
                    .order-item {
                        margin-bottom: 1rem;
                    }
                    .order-item .order-details li {
                        /*display: inline-block;*/
                        margin-top: 10px
                    }
                    .left small {
                        color: #f6b50c;
                    }
                    .pd {
                        color: #1d4f82;
                        font-weight: 600;
                    }
                </style>
    
                <div class="row mt-5" id="vendor-data">
                    <div class="col-12 col-lg-12 mb-4">
                        <h4 class="text-center">{{ $title }}</h4>
                        <hr class="chk_title_bar">
                    </div>
                    
                    <div class="col-md-6 offset-md-3">
                        <div class="row block text-center">
                        

                    @if( count($orders) > 0 )
                        @foreach( $orders as $order )

                        <div class="col-md-12 order-item">
                            <div class="card">
                                <div class="card-body">
                                    <h5>
                                        <div class="left">Order No. <small>{{ $order->unique_order_identifier }}</small></div>
                                        <div class="right">Status:
                                            <small>
                                                @if( $order->order_status == 1 )
                                                    Pending Confirmation
                                                @elseif( $order->order_status == 2 )
                                                    Forwarded to Shipping
                                                @endif    
                                            </small> 
                                        </div>
                                    </h5>
                                    <hr style="border-top: 1px solid #f2f3f3;">
                                    <div class="card-text">
                                    <?php 
                                        $details = DB::table('order_details')->select(['productName', 'categoryId', 'categoryName', 'featuredImage', 'order_details.rate', 'order_details.quantity'])
                                                    ->where('order_id', $order->id)
                                                    ->join('products', 'products.id', '=', 'order_details.product_id')
                                                    ->get();
                                    ?>

                                    <div class="row">
                                        
                                    
                                    @foreach( $details as $detail )

                                    <div class="col-md-6">
                                        <ul class="order-details">
                                        <li>
                                            <img src="{{ asset('uploads/products/thumbnails/' . $detail->featuredImage) }}" alt="" width="80" height="90">
                                        </li>
                                        <li class="pd">{{ $detail->productName }}</li>
                                        <li><small>Qty: {{ $detail->quantity }}</small></li>
                                        <li>
                                            NRs. {{ $detail->rate }}
                                        </li>
                                    </ul>
                                    </div>

                                    @endforeach
                                    </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-text">
                                        There are no pending orders.      
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    </div>
                    </div>

                </div>
            
        </div>
    </div>

    
@endsection