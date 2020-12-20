<style>
    .aj-cat-lists{
        background: #fff;
        /* color: rgb(17, 2, 2); */
        border-right: 2px solid #f2f2f2;
        min-height: 80px;
    }
    .aj-cat-name{
        font-size: 16px;
        color: black !important;
        text-transform: capitalize;
    }

    .aj-cat-row .aj-cat-lists:last-child {
        /* border: none; */
    }
</style>

<div class="col-12 pt-4" id="to-{{ $parentslug }}">
    
    <div class="row aj-cat-row">

    @foreach ($filter as $cat)
        <div class="col-md-2 col-12 pt-3 subcategory-single">
            <div class="row ">
                <div class="col-md-12 aj-cat-lists text-center p-3">
                    <a href="#" class="aj-cat-name aj-gt-product" data-id="{{ $cat->id }}">{{ $cat->name }}</a>
                </div>
            </div>
        
        </div>
    @endforeach
    </div>

    <div class="row">
        <div id="aj-product-list" class="pt-4">

        </div>
    </div>
</div>


<script src="{{ asset('themes/5/js/jquery/jquery-2.2.4.min.js') }}"></script>
<script>

    $(document).ready(function(){
        $('.aj-gt-product').click(function(e) {

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
                    url: '{{ url("category/ajax_get_products") }}',
                    data: {
                        cat_id,
                    },
                    success: function(data) {
                        // console.log(data);
                        $('#loader').hide();
                        $('#aj-product-list').html(data.html);
                        
                        $('html, body').animate({
                            scrollTop: $("#aj-product-list").offset().top
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
                        console.log('success');
                        alert("error!!!!");
                    }
                });

            });
    });
</script>