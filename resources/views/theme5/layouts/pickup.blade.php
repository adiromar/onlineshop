
<section class="single_blog_area offers section-padding-100" style="background: #f2f2f2;" id="what_we_offer">
    <div class="container">
        {{-- <div class="row justify-content-centerss"> --}}
            <div class="section-heading col-12 text-center">
                <h2>What We Offer</h2>
            </div>

            {{-- @if( $feat_category = App\Category::where('parentId', 0)->oldest()->get()->take(6) ) --}}
            <div class="row">
            @if( $parent )

                    @foreach ($parent as $cat)
                    {{-- @if( $cat->parent() )
                    @foreach( $cat->parent() as $parent) --}}
                    <div class="category-single">
                        <div class="hp-img">
                            <a href="#" class="p-cat" data-id="{{ $cat->id }}">
                              <img src="{{ asset('/' . $cat->image) }}" width="115" height="115" class="par-img" id="{{ $cat->id }}" alt="">
                            </a>

                            <span>{{ $cat->name }}</span>
                        </div>

                    </div>
                    {{-- @endforeach
                    @endif --}}

                    @endforeach
            @endif
            </div>

            <div class="row" id="scrollhere">
                <div class="col-md-12">
                    &nbsp;<br/>
                </div>
            </div>

            <div class="row">
                <div class="col-12 app-data" id="response">

                </div>
                <div class="row" id="scrollhere1">
                    <div class="col-md-12">
                        &nbsp;<br/>
                    </div>
                </div>
                <div class="col-12 aj-product-lists">

                </div>
            </div>

    </div>
</section>

<section class="single_blog_area most-popular" id="todays_deal">

    <div class="container">

    <div class="section-heading col-12 pt-4">
        <h2>Today's Deal</h2>
    </div>
    <?php $productList = App\Product::notsuspended()->orderBy('products.created_at', 'desc')->get(); ?>
    <div class="col-12">
        <div class="{{ count($productList) > 0 ? 'owl-carousel' : '' }} popular-slider">
            <!-- Start Single Product -->

            @if( count($productList) > 0 )
            @foreach ($productList->take(8) as $product)


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
                    <div class="product-price">
                    <span class="old">NRS.{{ $product->rate }}</span>
                        <span class="addcart">
                            <button class="btn btn-default btn-sm cart-btn add-to-cart" data-productid="{{$product->id}}" data-product="{{ $product->productName }}" data-rate="{{ $product->rate }}">Add To Cart</button>
                        </span>
                    </div>

                </div>
            </div>

            @endforeach
            @endif
            <!-- End Single Product -->
        </div>
    </div>
</div>
</section>


{{-- Discounted Products --}}
<section class="single_blog_area most-popular" id="discounted_products">

    <div class="container">

    <div class="section-heading col-12 pt-4">
        <h2>Discounted Products</h2>
    </div>
    <?php $productList = App\Product::productMostBought(8); ?>
    <div class="col-12">
        <div class="{{ $productList ? 'owl-carousel' : '' }} popular-slider">
            <!-- Start Single Product -->

            @if( $productList )
            @foreach ($productList as $product)

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
                    {{-- <div class="button-head">
                        <div class="product-action">
                            <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                            <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                            <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                        </div>
                        <div class="product-action-2">
                            <a title="Add to cart" href="#">Add to cart</a>
                        </div>
                    </div> --}}
                </div>
                <div class="product-content">
                <h3><a href="{{ route('view.product.new5', $product->slug) }}">{{ mb_strimwidth($product->productName, 0, 26, "...") }}</a></h3>
                    <div class="product-price">
                    <span class="old">NRS.{{ $product->rate }}</span>
                        <span class="addcart">
                            <button class="btn btn-default btn-sm cart-btn add-to-cart" data-productid="{{$product->id}}" data-product="{{ $product->productName }}" data-rate="{{ $product->rate }}">Add To Cart</button>
                        </span>
                    </div>

                    {{-- <div class="addcart">
                        <button class="btn btn-default btn-sm cart-btn">Add To Cart</button>
                    </div> --}}
                </div>
            </div>

            @endforeach
            @else
            <!-- End Single Product -->
            <!-- Start Single Product -->
            <!-- <div class="single-product">
                <div class="product-img">
                    <a href="product-details.html">
                        <img class="default-img" src="https://via.placeholder.com/550x750" alt="#">
                        <img class="hover-img" src="https://via.placeholder.com/550x750" alt="#">
                    </a>
                    <div class="button-head">
                        <div class="product-action">
                            <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                            <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                            <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                        </div>
                        <div class="product-action-2">
                            <a title="Add to cart" href="#">Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="product-content">
                    <h3><a href="product-details.html">Women Hot Collection</a></h3>
                    <div class="product-price">
                        <span>$50.00</span>
                    </div>
                </div>
            </div> -->
            <!-- End Single Product -->
            <!-- Start Single Product -->
            <!-- <div class="single-product">
                <div class="product-img">
                    <a href="product-details.html">
                        <img class="default-img" src="https://via.placeholder.com/550x750" alt="#">
                        <img class="hover-img" src="https://via.placeholder.com/550x750" alt="#">
                        <span class="new">New</span>
                    </a>
                    <div class="button-head">
                        <div class="product-action">
                            <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                            <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                            <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                        </div>
                        <div class="product-action-2">
                            <a title="Add to cart" href="#">Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="product-content">
                    <h3><a href="product-details.html">Awesome Pink Show</a></h3>
                    <div class="product-price">
                        <span>$50.00</span>
                    </div>
                </div>
            </div> -->
            <!-- End Single Product -->
            <!-- Start Single Product -->
            <!-- <div class="single-product">
                <div class="product-img">
                    <a href="product-details.html">
                        <img class="default-img" src="https://via.placeholder.com/550x750" alt="#">
                        <img class="hover-img" src="https://via.placeholder.com/550x750" alt="#">
                    </a>
                    <div class="button-head">
                        <div class="product-action">
                            <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                            <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                            <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                        </div>
                        <div class="product-action-2">
                            <a title="Add to cart" href="#">Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="product-content">
                    <h3><a href="product-details.html">Awesome Bags Collection</a></h3>
                    <div class="product-price">
                        <span>$50.00</span>
                    </div>
                </div>
            </div> -->

            @endif
            <!-- End Single Product -->
        </div>
    </div>
</div>
</section>


{{-- Trending Sales Products --}}
<section class="single_blog_area most-popular pb-5" id="trending_sales">

    <div class="container">

    <div class="section-heading col-12 pt-4">
        <h2>Trending Sales</h2>
    </div>
    <?php $productList = App\Product::productSales(); ?>
    <div class="col-12">
        <div class="{{ $productList ? 'owl-carousel' : '' }} popular-slider">
            <!-- Start Single Product -->

            @if( $productList )
            @foreach ($productList as $product)


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
                    {{-- <div class="button-head">
                        <div class="product-action">
                            <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                            <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                            <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                        </div>
                        <div class="product-action-2">
                            <a title="Add to cart" href="#">Add to cart</a>
                        </div>
                    </div> --}}
                </div>
                <div class="product-content">
                <h3><a href="{{ route('view.product.new5', $product->slug) }}">{{ mb_strimwidth($product->productName, 0, 26, "...") }}</a></h3>
                    <div class="product-price">
                    <span class="old">NRS.{{ $product->rate }}</span>
                        <span class="addcart">
                            <button class="btn btn-default btn-sm cart-btn add-to-cart" data-productid="{{$product->id}}" data-product="{{ $product->productName }}" data-rate="{{ $product->rate }}">Add To Cart</button>
                        </span>
                    </div>

                    {{-- <div class="addcart">
                        <button class="btn btn-default btn-sm cart-btn">Add To Cart</button>
                    </div> --}}
                </div>
            </div>

            @endforeach
            @else
            <!-- End Single Product -->
            <!-- Start Single Product -->
            <!-- <div class="single-product">
                <div class="product-img">
                    <a href="product-details.html">
                        <img class="default-img" src="https://via.placeholder.com/550x750" alt="#">
                        <img class="hover-img" src="https://via.placeholder.com/550x750" alt="#">
                    </a>
                    <div class="button-head">
                        <div class="product-action">
                            <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                            <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                            <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                        </div>
                        <div class="product-action-2">
                            <a title="Add to cart" href="#">Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="product-content">
                    <h3><a href="product-details.html">Women Hot Collection</a></h3>
                    <div class="product-price">
                        <span>$50.00</span>
                    </div>
                </div>
            </div> -->
            <!-- End Single Product -->
            <!-- Start Single Product -->
            <!-- <div class="single-product">
                <div class="product-img">
                    <a href="product-details.html">
                        <img class="default-img" src="https://via.placeholder.com/550x750" alt="#">
                        <img class="hover-img" src="https://via.placeholder.com/550x750" alt="#">
                        <span class="new">New</span>
                    </a>
                    <div class="button-head">
                        <div class="product-action">
                            <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                            <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                            <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                        </div>
                        <div class="product-action-2">
                            <a title="Add to cart" href="#">Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="product-content">
                    <h3><a href="product-details.html">Awesome Pink Show</a></h3>
                    <div class="product-price">
                        <span>$50.00</span>
                    </div>
                </div>
            </div> -->
            <!-- End Single Product -->
            <!-- Start Single Product -->
            <!-- <div class="single-product">
                <div class="product-img">
                    <a href="product-details.html">
                        <img class="default-img" src="https://via.placeholder.com/550x750" alt="#">
                        <img class="hover-img" src="https://via.placeholder.com/550x750" alt="#">
                    </a>
                    <div class="button-head">
                        <div class="product-action">
                            <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                            <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                            <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                        </div>
                        <div class="product-action-2">
                            <a title="Add to cart" href="#">Add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="product-content">
                    <h3><a href="product-details.html">Awesome Bags Collection</a></h3>
                    <div class="product-price">
                        <span>$50.00</span>
                    </div>
                </div>
            </div> -->

            @endif
            <!-- End Single Product -->
        </div>
    </div>
</div>

<script src="{{ asset('themes/5/js/jquery/jquery-2.2.4.min.js') }}"></script>
<script>

    $(document).ready(function(){
        $('.p-cat').click(function(e) {

                // alert($(this).data('id'));
                e.preventDefault();

                $('#loader').show();
                let cat_id = $(this).data('id');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ url("parent/ajax_sub_cat") }}',
                    data: {
                        cat_id,
                    },
                    success: function(data) {
                        // console.log(data);
                        $('#loader').hide();
                        $('#todays_deal').hide();
                        $('#discounted_products').hide();
                        $('#trending_sales').hide();
                        $('#response').html(data.html);

                        $('html, body').animate({
                            scrollTop: $("#scrollhere").offset().top
                        }, 2000);

                        // Add to cart
                        $('.add-to-cart').click(function(e) {
                            e.preventDefault();
                            // alert("hello");
                            let productId = $(this).data('productid');
                            let productName = $(this).data('product');
                            let rate = $(this).data('rate');

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: 'POST',
                                url: '{{ url("cart/ajax") }}',
                                data: {
                                    productId,
                                    productName,
                                    rate
                                },
                                success: function(data) {
                                    console.log(data);
                                    if (data.status == 200) {

                                        let count = $('.total-count').text();
                                        let cartcount = parseInt(count) + 1;
                                        $('.total-count').text(cartcount);
                                        $('.cart-count').text(cartcount + ' Item(s)');

                                        Swal.fire({
                                            title: 'Success!',
                                            text: 'Item added to your cart.',
                                            icon: 'success',
                                            confirmButtonText: 'Ok'
                                        })
                                        // reload page
                                        // window.location.reload();
                                    } else {

                                        Swal.fire({
                                            text: 'Item already on your cart.',
                                            icon: 'error',
                                            confirmButtonText: 'Exit'
                                        })
                                    }
                                }
                            });

                        });

                        // Add to Wish List
                        $('.add-to-wishlist').click(function(e) {
                            e.preventDefault();
                            let curr = $(this);
                            let productId = $(this).data('product');

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: 'POST',
                                url: '{{ url("wishlist/ajax") }}',
                                data: {
                                    productId
                                },
                                success: function(data) {

                                    if (data.status == 200) {

                                        curr.find('.fa-heart').toggleClass('active');
                                        Swal.fire({
                                            title: 'Success!',
                                            text: data.message,
                                            icon: 'success',
                                            confirmButtonText: 'Ok'
                                        })

                                    } else {

                                        Swal.fire({
                                            text: 'Please login to add this item in the wish list.',
                                            icon: 'error',
                                            confirmButtonText: 'Exit'
                                        })

                                    }

                                }
                            });

                        });

                    },error:function(){
                        $('#loader').hide();
                        // alert("error!!!!");
                    }
                });

            });
    });
</script>

</section>
