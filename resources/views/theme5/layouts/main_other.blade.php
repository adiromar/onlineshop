<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>Chaiyo.shop - Chaiyo Online</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/core-img/favicon.ico') }}">

    <!-- Core Stylesheet -->
    <link href="{{ asset('themes/5/main.css') }}" rel="stylesheet">

    <!-- Responsive CSS -->
    <link href="{{ asset('themes/5/css/responsive/responsive.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('themes/5/css/others/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/5/css/others/slick-theme.css') }}">

</head>

<body>
    <!-- Preloader Start -->
    <div id="preloader">
        <div class="loader">
            <span class="inner1"></span>
            <span class="inner2"></span>
            <span class="inner3"></span>
        </div>
    </div>

    <!-- Search Form Area -->
    <div class="fancy-search-form d-flex align-items-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Close Btn -->
                    <div class="search-close-btn" id="closeBtn">
                        <i class="ti-close" aria-hidden="true"></i>
                    </div>
                    <!-- Form -->
                    <form action="#" method="get">
                        <input type="search" name="fancySearch" id="search" placeholder="| Enter Your Search...">
                        <input type="submit" class="d-none" value="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('theme5.layouts.head_other')

    @yield('modals')

    @yield('order-section')

    @yield('pickup')

    @yield('playstore')

    @yield('whysection')

    @yield('content')


    <!-- ***** Footer Area Start ***** -->
    <footer class="fancy-footer-area fancy-bg-dark">
        <div class="footer-content section-padding-80-50">
            <div class="container">
                <div class="row">
                    <!-- Footer Widget -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="single-footer-widget">
                            {{-- <h6>Our Newsletter</h6> --}}
                            {{-- <p>Subscribe to our mailing list to get the updates to your email inbox.</p> --}}
                            {{-- <form action="#" method="get">
                                <input type="search" name="search" id="footer-search" placeholder="E-mail">
                                <button type="submit">Subscribe</button>
                            </form> --}}

                            <a href="{{ url('/') }}"><img class="navbar-brand" src="{{ asset('themes/5/logos/CS-12.jpg') }}" alt="Fatafat logo" width="135" height="70"></a>

                            <div class="footer-social-widegt d-flex align-items-center">
                                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Footer Widget -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="single-footer-widget">
                            <h6>Twitter Feed</h6>
                            <div class="single-tweet">
                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i> With the popularity of podcast shows growing with each year, you might consider starting it yourself as well. <br> </a>
                                <span>About 20 hours ago</span>
                            </div>
                        </div>
                    </div>
                    <!-- Footer Widget -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="single-footer-widget">
                            <h6>Link Categories</h6>
                            <nav>
                                <ul>
                                    <li><a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Agency</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Home</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Studio</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i> About</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Studio</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Services</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Blogs</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Work</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Shop</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Privacy</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- Footer Widget -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="single-footer-widget">
                            <h6>Contact Us</h6>
                            <p>1 (800) 686-6688 <br>info.company@gmail.com
                            </p>
                            <p>40 Baria Sreet 133/2 <br>NewYork City, US</p>
                            <p>Open hours: 8.00-18.00 Mon-Fri</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Copywrite -->
        <div class="footer-copywrite-area">
            <div class="container h-100">
                <div class="row h-100">
                    <div class="col-12 h-100">
                        <div class="copywrite-content h-100 d-flex align-items-center justify-content-between">
                            <!-- Copywrite Text -->
                            <div class="copywrite-text">
                                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved |  <a href="https://encoderslab.com" target="_blank">Encoderslab</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                            </div>
                            <!-- Footer Nav -->
                            <div class="footer-nav">
                                <nav>
                                    <ul>
                                        <li><a href="#">Disclaimer</a></li>
                                        <li><a href="#">Privacy</a></li>
                                        <li><a href="#">Advertisement</a></li>
                                        <li><a href="#">Contact us</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ***** Footer Area End ***** -->

    <!-- jQuery-2.2.4 js -->
    <script src="{{ asset('themes/5/js/jquery/jquery-2.2.4.min.js') }}"></script>
    <!-- Popper js -->
    <script src="{{ asset('themes/5/js/bootstrap/popper.min.js') }}"></script>
    <!-- Bootstrap-4 js -->
    <script src="{{ asset('themes/5/js/bootstrap/bootstrap.min.js') }}"></script>
    <!-- All Plugins js -->
    <script src="{{ asset('themes/5/js/others/plugins.js') }}"></script>
    <!-- Active JS -->
    <script src="{{ asset('themes/5/js/active.js') }}"></script>
    <script src="{{ asset('themes/5/js/others/slick.min.js') }}"></script>
    <script type="text/javascript" src="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          $('.slick-main').slick({
            navs: true,
            infinite: false,
            speed: 300,
            slidesToShow: 8,
            slidesToScroll: 8,
            responsive: [
                {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    navs: true
                }
                },
                {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
                },
                {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
});


// Add to Cart 
$('.add-to-cart').click(function(e) {
                e.preventDefault();

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

            // Sort Product
            $('.sort-product').change(function() {

                window.location = `?sort=` + $(this).val();

            });

// Add to 
$('.filter-cat').click(function(e) {
                e.preventDefault();

                let catId = $(this).data('cat_id');
            
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ url("ajax/itemList") }}',
                    data: {
                        catId,
                    },
                    success: function(data) {
                        console.log(data.supplier);
                        if (data.status == 200) {
                            console.log('Success');

                            
                            
                    
                    // table = '#vendor-data';
                    // const data1 = JSON.parse(data);
                    // console.log(data1);
                    $.each(data.supplier, function(key, val) {
                        console.log(key);
                        $("#vendor-data").html('<div class="col-lg-4 col-md-12 mb-3">'+
                        '<div class="card card-main">'+
                            '<div class="card-inner">'+
                                '<div class="card-image">'+
                                    '<img src="{{ asset("themes/5/img/ansari.jpg") }}" class="card-image-view">'+
    
                                    '<p class="closed-tag">Closed</p>'+
                                '</div>'+
                                '<div class="card-right">'+
                                    '<div class="card-heading">'+
                                        '<span>'+val.merchantId+'</span>'+
                                    '</div>'+
                                    '<div class="card-info">'+
                                        '<p>4.22 km - Sukhdev Market</p>'+
                                    '</div>'+
                                    '<div class="card-description">'+
                                        '<p>No Rating Yet</p>'+
                                    '</div>'+
    
                                    '<div class="viewmenu">'+
                                        '<a href="">View Menu <i class="fa fa-angle-right"></i></a>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>');

                    });


                    // $("#vendor-data").html(app);

                        } else {
                            console.log('some error occurred');
                        }
                    }
                });

            });


});
      </script>

    <script>
		// init wow js
		new WOW().init();


        $( document ).ready(function() {
       var owl = $('.owl-main');
   owl.owlCarousel({
       items:5,
       loop:true,
       margin:10,
       // autoplayDelay: 6000,
       autoplay:true,
       autoplayTimeout:4000,
       autoplayHoverPause:true,
    //    nav: true,
    //    navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"],
       dots: true,	
       responsive: {
       0: {
         items: 1
       },
   
       600: {
         items: 3
       },
   
       1024: {
         items: 5
       },
   
       1366: {
         items: 1
       }
     }
   });
});
   </script>

</body>