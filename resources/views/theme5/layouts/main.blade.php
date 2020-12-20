<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <!-- Title -->
    <title>Chaiyo.shop - Chaiyo Online</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('themes/5/img/favicon.ico') }}">

    <!-- Core Stylesheet -->
    <link href="{{ asset('themes/5/main.css') }}" rel="stylesheet">

    <!-- Responsive CSS -->
    <link href="{{ asset('themes/5/css/responsive/responsive.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('themes/5/css/others/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/5/css/others/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/5/vendors/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('themes/5/main.css') }}" type="text/css">

    @yield('styles')

    <style>
        .navbar-toggler span {
            background: none !important;
        }
        .slick-main .slick-arrow {
            padding: 0px;
        }
        .slick-main .slick-next {
            margin-right: -35px;
        }
        .slick-main .slick-previous {
            margin-right: 15px;
        }
        .slick-main .slick-arrow:before {
            font-size: 30px;
        }
      .review-btn.btn-danger {
        margin-top: 10px;
        margin-bottom: 10px;
      }
      .terms {
        width: 100% !important;
      }
      .owl-stage-outer {
        margin-top: -25px;
      }
      .section-padding-100 {
        padding-top: 30px !important;
        padding-bottom: 0px !important;
      }
      .owl-dots {
        display: none;
      }
      .input-group-addon {
        cursor: pointer;
      }
      .category-single {
        flex: 0 1 16.6%;
        padding: 15px;
        }
        .category-single span {
            display: block;
        }
        .filter-bar .sorting {
            margin-left: -25px;
        }
        .single-product {
            margin: 5px;
        }
        .page-footer {
            background-color: #100f0f;
            height: auto;
            padding: 1rem 0rem;
        }
        .page-footer .footer-menu {
            display: -webkit-box;
        }
        .page-footer .footer-menu li {
            margin-left: 15px;
        }
        .page-footer .footer-menu li a {
            color: grey;
        }
        .slick-home .slick-active img {
            /*height: 450px;*/
            height: 520px;
        }
        .slick-home .slick-slide img {
            height: 520px;
        }
        .slick-prev, .slick-next {
            top: 40% !important;
        }
        .offers {
            margin-top: 4.5rem;
        }
        .filter-bar {
            padding: 0 0 10px 30px;
        }
        .search-mobile {
            display: none;
        }
        .fancy-breadcumb-area {
            margin-top: 70px;
        }
        .for-mobile {
            display: none;
        }
      @media only screen and (min-width: 576px) and (max-width: 767px) {
        .category-single {
            flex: 0 1 33%;
            padding: 15px;
        }
        .subcategory-single {
            flex: 0 1 33%;
        }
        #aj-product-list .row .single-product {
            flex: 0 1 32%;
        }
      }

      @media only screen and (max-width: 575px) {
        .offer {
            margin-top: 0.5rem;
        }
        .for-mobile {
            display: unset;
        }
        .hide-on-mobile {
            display: none;
        }
        .for-mobile .reviews-wrapper {
            margin-top: 0.5rem;
        }
        .p-70s {
            margin-top: 65px;
        }
        .search-mobile {
            display: block;
            margin-top: -50px;
            padding-right: 10px;
        }
        .navbar.navbar-expand-lg {
            margin-top: -25px;
        }
        .grp-height {
            height: 30px;
        }
        .search-box {
            display: none;
        }
        .col-xs-6 {
            flex: 0 1 45%;
            padding: 0px;
            margin: 5px;
        }
        .slick-main .slick-next {
            margin-right: -10px;
        }
        .slick-main .slick-prev {
            left: -2%;
        }
        .category-pg.show-banner img {
            object-fit: cover;
            height: 320px;
            object-position: 5% 0;
        }
        .slick-home .slick-active img {
            height: 240px;
        }
        .fancy-breadcumb-area {
            margin-bottom: -215px;
        }
        .header_area {
            padding: 0rem;
            height: 120px;
            margin-bottom: 2rem;
        }
        .fancy-breadcumb-area {
            margin-top: 120px;
        }
        .page-footer .footer-menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .sidebar-right.side-notes{
            margin-right: 35px;
        }
        .page-footer .footer-menu li a {
            font-size: 14px;
        }
        .copywrite-content {
            flex-wrap: wrap;
        }
        #fancyNav {
            width: 100%;
            padding: 1rem;
            border: 1px solid #b1c5da;
            margin-right: 5px;
            z-index: 1;
        }
        .search-form .grp-height input {
            width: 100%;
        }
        .category-single {
            flex: 0 1 49.8%;
        }
        .subcategory-single {
            flex: 0 1 49.8%;
        }
        .category-single img {
            height: 110px;
        }
        #aj-product-list .row .single-product {
            flex: 0 1 46.8%;
        }
         .single-product .product-content h3 {
          line-height: 15px;
        }
        .single-product .product-content h3 a {
          font-size: 13px;
        }
        .single-product .product-content .old {
          font-size: 13px;
          display: block;
          margin-bottom: 10px;
          margin-top: 15px;
        }
        .addcart .cart-btn {
          font-size: 11px;
          padding: 2px 4px;
          float: left;
        }
        .single-product .product-img .abs-btn span.sale {
          font-size: 11px;
          padding: 1px 6px;
          left: 0px;
          height: auto;
          line-height: 20px;
          top: 0%;
        }
        .single-product .product-img .abs-btn span.wishlist {
            top: 0%;
        }
        .single-product .product-img a img {
          width: 85%;
          height: 110px;
        }
        .single-product .product-content {
          margin-top: 0px;
        }
        .single-product {
          margin: 50px 5px 0px 12px !important;
          min-height: 220px;
          padding: 5px 5px 35px 10px;
        }
        .most-popular .owl-carousel .owl-nav div {
          margin-left: -8px;
        }
      }

    </style>

</head>

<body>

    <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '{your-app-id}',
            cookie     : true,
            xfbml      : true,
            version    : '{api-version}'
          });

          FB.AppEvents.logPageView();

        };

        (function(d, s, id){
           var js, fjs = d.getElementsByTagName(s)[0];
           if (d.getElementById(id)) {return;}
           js = d.createElement(s); js.id = id;
           js.src = "https://connect.facebook.net/en_US/sdk.js";
           fjs.parentNode.insertBefore(js, fjs);
         }(document, 'script', 'facebook-jssdk'));
      </script>

    <!-- Preloader Start -->
    <div id="preloader">
        <div class="loader">
            <span class="inner1"></span>
            <span class="inner2"></span>
            <span class="inner3"></span>
        </div>
    </div>

<div id="loader" style="display: none">
    <img src="{{ asset('themes/5/ajax-loader.gif') }}" />
</div>

<div>
    <div style="display: none;" class="list-create-card__holder" data-toggle="collapse" href="#notes_sec">
         <div class="list-create-card__inner">
            <div class="list-create-card">
                <div class="list-create-card__head">
                    <div class="list-create-card__list-title">
                        <p>Shopping List</p>
                    </div>
                    <div class="list-create-card__item-count">
                        0 items
                    </div>
                </div>
            </div>
         </div>
    </div>
</div>
<aside id="notes_sec" class="collapse sidebar-right side-notes">
    <div class="collapsssse" id="notes_secss">
        <div class="cards card-bodys" style="background: #fff;">
            {{-- <p class="p-3">Shopping Lists</p>

            <a class="pull-right" data-toggle="collapse" href="#notes_sec"><i class="ti-angle-right"></i></a>
             --}}
            <div class="row p-3">
                    <div class="col-md-6 col-12">
                        <h6 class="">Shopping Lists</h6>
                    </div>
                    <div class="col-md-6 col-12">
                        <a class="pull-right" data-toggle="collapse" href="#notes_sec">Collapse <i class="ti-angle-right"></i></a>
                    </div>
            </div>

          <div>
              <div class="list-card-holder">
                <div class="list-create-card " id="">
                    <div class="col-12 p-3" id="dynamic-list">

                    </div>
                    <div class="list-single" style="position: relative;">
                        <div class="list-create-plus">
                            <i class="ti ti-plus" onclick="addItem()"></i>
                        </div>
                        <div class="list-create-input">
                            <input type="text" id="candidate" class="note-text" placeholder="Add New Item">
                        </div>
                        <div class="list-create-check">
                            <i class="ti ti-check" onclick="addItem()"></i>
                            <i class="ti ti-trash" onclick="removeItem()"></i>
                        </div>
                    </div>

                </div>

                <div class="col-12 col-lg-12">
                    <input type="submit" id="submit_notes" class="btn btn-default notes_submit col-12" value="Search This List">
                </div>
              </div>
          </div>
        </div>
    </div>
</aside>


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
                        <input type="search" name="fancySearch" id="search2" placeholder="| Enter Your Search...">
                        <input type="submit" class="d-none" value="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('theme5.layouts.head')

    @yield('modals')

    @yield('order-section')

    @yield('pickup')

    {{-- @yield('playstore') --}}

    {{-- @yield('whysection') --}}

    @yield('content')

    <style>
        .white-text,
        .single-footer-widget p {
            color: white;
        }
        .single-footer-widget a,
        .single-footer-widget a:not([href]) {
          display: block; /* Make the links appear below each other */
          text-decoration: none; /* Remove underline from links */
          font-size: 14px;
          margin-bottom: 15px;
          color: white;
        }
        .single-footer-widget .social-links a {
            display: inline-block;
            margin-right: 10px;
        }
        .single-footer-widget .social-links a.top {
            padding: 7px 5px 0px 15px;
        }
        .single-footer-widget .social-links a {
            color: #1d4f82;
            border: 1px solid;
            background-color: white;
            padding: 6px 8px 0px 8px;
            border-radius: 10px;
        }
        .sub-title {
            margin-top: 1rem;
        }
        .single-footer-widget .app-links a {
            color: #1d4f82;
            border: 1px solid white;
            background-color: white;
            padding: 4px 15px;
            width: 180px;
            border-radius: 8px;
            display: flex;
        }
        .single-footer-widget .app-links a span {
            font-size: 18px;
            font-weight: 600;
        }
        .app-links small {
            display: block;
            margin-bottom: -4px;
        }
        .app-links .icon-text {
            padding-left: 10px;
        }
        .app-links .icon svg {
            height: 30px;
            margin-top: 3px;
        }
    </style>
    <!-- ***** Footer Area Start ***** -->
    <footer class="fancy-footer-area fancy-bg-dark">
        <div class="footer-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 pull-left">
                        <a href="{{ url('/') }}"><img class="navbar-brand" src="{{ asset('themes/5/img/logo-footer.png') }}" alt="Chaiyo logo" style=""></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-xs-12">
                        <div class="single-footer-widget">
                            <h6>DISCOVER</h6>

                            <a class="white-text" href="">About Us</a>
                            <a class="white-text" href="">How to place order</a>
                            <a class="white-text" href="">FAQs</a>
                            <a class="white-text" href="">Support & help</a>
                            <a class="white-text" href="">Partner with us</a>

                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-xs-12">
                        <div class="single-footer-widget">
                            <h6>CONTACT US</h6>

                            <p>01-4106958</p>
                            <p>office.chaiyoshop@gmail.com</p>
                            <p>31 - Aloknagar, New Baneshwor, Kathmandu</p>

                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-xs-12">
                        <div class="single-footer-widget">
                            <h6>TERMS & POLICIES</h6>

                            <a href="">Terms of service</a>
                            <a href="">Shipping Policy</a>
                            <a href="">Return Policy</a>
                            <a href="">Privacy Statement</a>

                        </div>
                    </div>
                    <?php
                        $settings = App\Setting::first();
                        $socialLinks = $settings ? $settings->socialLinks : null;
                        $socialLinks = json_decode($socialLinks);
                        $fblink = $socialLinks ? $socialLinks->facebook : '';
                        $ttlink = $socialLinks ? $socialLinks->twitter : '';
                        $ytlink = $socialLinks ? $socialLinks->youtube : '';
                    ?>
                    <div class="col-sm-12 col-md-3 col-xs-12">
                        <div class="single-footer-widget">
                            <h6>FOLLOW US ON</h6>
                            <div class="social-links">
                                <a href="{{ $fblink }}" class="top" target="_blank"><i class="fa fa-facebook fa-2x"></i></a>
                                <a href="{{ $ttlink }}" target="_blank"><i class="fa fa-instagram fa-2x"></i></a>
                                <a href="{{ $ytlink }}" target="_blank"><i class="fa fa-twitter fa-2x"></i></a>
                            </div>
                            <h6 class="sub-title">DOWNLOAD APP</h6>
                            <div class="app-links">
                                <a href="">
                                    <div class="icon">
                                        <i class="fa fa-2x fa-apple"></i>
                                    </div>
                                    <div class="icon-text">
                                        <small>Get it on</small>
                                        <span>App Store</span>
                                    </div>
                                </a>
                                <a href="">
                                    <div class="icon">
                                        @component('components.play-store')
                                        @endcomponent
                                    </div>
                                    <div class="icon-text">
                                        <small>Download on the</small>
                                        <span>Google Play</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="white-text">
                            Copyright &copy; 2020, www.Chaiyo.shop. All rights reserved.
                        </p>
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
    <script src="{{ asset('themes/5/js/jquery.nice-select.min.js') }}"></script>

    <script src="{{ asset('themes/5/js/others/plugins.js') }}"></script>
    <!-- Active JS -->
    <script src="{{ asset('themes/5/js/active.js') }}"></script>
    <script src="{{ asset('themes/5/js/others/slick.min.js') }}"></script>
    <script type="text/javascript" src="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script type="text/javascript">

    function addItem(){

	var ul = document.getElementById("dynamic-list");
  var candidate = document.getElementById("candidate");
  var li = document.createElement("li");
  li.setAttribute('id',candidate.value);
  li.appendChild(document.createTextNode(candidate.value));
  ul.appendChild(li);
  $(candidate).val('');
}

function removeItem(){
	var ul = document.getElementById("dynamic-list");
  var candidate = document.getElementById("candidate");
  var item = document.getElementById(candidate.value);
  ul.removeChild(item);
}

    @if( Session::has('success') )

        Swal.fire({
            text: '{{ Session::get("success") }}',
            icon: 'success',
            confirmButtonText: 'Ok'
        })

    @endif

    @if( Session::has('info') )

        Swal.fire({
            text: '{{ Session::get("info") }}',
            icon: 'info',
            confirmButtonText: 'Ok'
        })

    @endif

    @if( Session::has('error') )

        Swal.fire({
            text: '{{ Session::get("error") }}',
            icon: 'error',
            confirmButtonText: 'Ok'
        })

    @endif

    $(document).ready(function() {
        $('.nic-select').niceSelect();
    });

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
                    slidesToShow: 1,
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
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
});

$('.slick-home').slick({
  dots: true,
  navs: false,
//   lazyLoad: 'ondemand',
//   infinite: false,
  autoplay: true,
  autoplaySpeed: 20000,
  slidesToShow: 1,
//   adaptiveHeight: true,
  fade: true,
  cssEase: 'linear'
});



});
      </script>

    <script>
		// init wow js
		new WOW().init();


        $( document ).ready(function() {
       var owl = $('.owl-main');
   owl.owlCarousel({
       items:4,
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

   var owl1 = $('.owl-carousel');
//    var owl1 = $(".owl-carousel, .owl-carousel2, .owl-carousel3").each(function() {
   owl1.owlCarousel({
       items:4,
       loop:true,
       margin:5,
       // autoplayDelay: 6000,
       autoplay:true,
       autoplayTimeout:4000,
       autoplayHoverPause:true,
       nav: true,
       navText:["<div class='nav-btn prev-slide'><i class='ti-angle-left'></i></div>","<div class='nav-btn next-slide' ><i class='ti-angle-right'></i></div>"],
       dots: true,
       responsive: {
       0: {
         items: 2
       },

       600: {
         items: 3
       },

       1024: {
         items: 4
       },

       1366: {
         items: 4
       }
     }
   });



// Add to Cart
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
                        // console.log(data);
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
                            // location.reload();

                            Swal.fire({
                                title: 'Success!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            });

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

            $('.add-item').click(function(e) {
                e.preventDefault();
                // alert('alert');
		        $(this).submit();
            });
            $('.minus-item').click(function(e) {
                e.preventDefault();
                // alert('alert');
		        $(this).submit();
            });
            $('.submit-form').change(function(e){
                e.preventDefault();
                // alert("hello");
		        $(this).submit();
	        });

   // Add to

$('.hp-img').on('click', function(e){
  e.preventDefault();
  $val = $('.hp-img');
  $val.not(this).removeClass('main-cat-style');
//   $(this).css('border', '2px solid #1c4f81');
  $(this).addClass('main-cat-style');
});

$('.aj-cat-name').on('click', function(e){
  e.preventDefault();
  $val = $('.aj-cat-name');
  $val.not(this).removeClass('main-product-toggle');
//   alert('click this');
//   $(this).css('background', '#1c4f81');
  $(this).addClass('main-product-toggle');
//   $(this).closest("div").addClass("main-product-toggle");
});

$('.input-group-addon').click(function(){
  $(this).closest('.search-form').submit();
});

});
   </script>

   @yield('scripts')

</body>
