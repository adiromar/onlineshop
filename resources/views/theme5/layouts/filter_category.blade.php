<section>

  <div class="row">
    @if(count($filter) > 0 )
        @foreach ($filter as $product)

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
        <style>
          .refresh {
            padding: 4px 15px;
            border: 2px solid #1d4f82;
            border-radius: 5px;
            font-weight: 600;
            color: #1d4f82;
          }
        </style>
        <div class="col-12 col-lg-12 text-center" style="padding:2rem;">
            <span style="padding: 2rem;"></span>
            <h4 style="padding: 2rem;">No Products Available</h4>
            <a href="{{ url('/') }}" class="refresh">Refresh</a>
        </div>
    @endif
  </div>

</section>
