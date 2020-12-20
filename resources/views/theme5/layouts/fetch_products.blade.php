
    @if(count($filter) > 0)


    <div class="col-md-12 pb-3" >
        <div class="filter-bar d-flex flex-wrap align-items-center">
           
            <div class="sorting">
                <select class="nic-select sort-product" name="sort" class="form-control">
                    <option value="name">Sort By Name <i class="fa fa-chevron-down"></i></option>
                    <option value="low_high" {{ request()->sort == 'low_high' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="high_low" {{ request()->sort == 'high_low' ? 'selected' : '' }}>Price: High to Low</option>
                </select>

            </div>
          </div>
    </div>

    <div class="row">
        
    @foreach ($filter as $product)



    <div class="single-product">
        <div class="product-img">
            <a href="#">
                <a href="{{ route('view.product.new5', $product->slug) }}"><img class="default-img" src="{{ asset('uploads/products/thumbnails/' . $product->featuredImage) }}" alt="#"></a>
                
            </a>
            <div class="abs-btn">
                <span class="sale">Sale</span>

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
            <div class="product-price">
            <span class="old">NRS.{{ $product->rate }}</span>
                <span class="addcart">
                    <button class="btn btn-default btn-sm cart-btn add-to-cart" data-productid="{{$product->id}}" data-product="{{ $product->productName }}" data-rate="{{ $product->rate }}">Add To Cart</button>
                </span>
            </div>

        </div>
    </div>
    @endforeach
    @else
      <p>No Products Available</p>
    @endif

</div>