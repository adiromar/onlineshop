

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
                <form action="{{ route('search.product5') }}" method="post">
                    {{ csrf_field() }}

                    <input type="search" name="search" id="search" placeholder="| Enter Your Search...">
                    <input type="submit" class="d-none" value="submit">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ***** Header Area Start ***** -->
<header class="header_area" id="header">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-12 h-100">
                <nav class="h-100 navbar navbar-expand-lg align-items-center">
                    <!-- <a class="navbar-brand" href="index.html">fancy</a> -->
                    <a href="{{ url('/') }}"><img class="navbar-brand" src="{{ asset('themes/5/img/Logo.png') }}" alt="Chaiyo logo" width="auto" height="auto"></a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#fancyNav" aria-controls="fancyNav" aria-expanded="false" aria-label="Toggle navigation"><span class="ti-menu"></span></button>
                    <div class="collapse navbar-collapse" id="fancyNav">
                        <ul class="navbar-nav ml-auto">

                            <li class="nav-item search-box">
                                <form action="{{ route('search.product5') }}" method="post" class="search-form">
                                        {{ csrf_field() }}
                                    <div class="input-group grp-height">
                                        <input type="search" name="search" placeholder="Search For Groceries, Fashion, Medicine">
                                        <span class="input-group-addon">
                                            <i class="fa fa-search">
                                                <input type="hidden" class="d-none" value="submit">
                                            </i>
                                            
                                        </span>
                                    </div>
                                </form>
                                {{-- <a class="nav-link" id="search-btn" href="#"><i class="fa fa-search"></i></i> Search</a> --}}
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/show-cart') }}"><i class="ti-shopping-cart"></i> Cart <span class="badge total-count">{{ Cart::content()->count() }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#notes_sec" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="ti-notepad"></i> Notes</a>
                            </li>
                            @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti-user"></i> {{ Auth()->user()->username}}</a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                @if(Auth::user()->hasRoles('admin'))
                                    <a href="{{ url('/admin') }}" class="dropdown-item">Admin</a>
                                @elseif(Auth::user()->hasRoles('supplier'))
                                    <a href="{{ url('/admin') }}" class="dropdown-item">Dashboard</a>
                                @endif

                                @if( Auth::user()->hasRoles('Delivery') )
                                    <a href="{{ url('admin/delivery-user/list/') }}" class="dropdown-item">To Deliver</a>
                                @else
                                    <a href="{{ route('wish5', Auth::id()) }}" class="dropdown-item"> Wishlist</a>
                                    <a href="{{ route('front.users.orders', Auth::id()) }}" class="dropdown-item">My Orders</a>
                                    <a href="{{ route('user.shipping.details', Auth::id() ) }}"class="dropdown-item">Shipping Details</a>
                                @endif

                                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{csrf_field()}}
                                </form>
                                </div>
                            </li>
                            @endauth

                            {{-- <li class="nav-item active">
                                <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                            </li> --}}
                            

                            {{-- <li class="nav-item">
                                <a class="nav-link" href="#">Partners</a>
                            </li> --}}
                            
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="#">Merchant</a>
                            </li> --}}
                            
                            @guest

                            <li class="nav-item">
                                {{-- <a class="nav-link" href="#" data-toggle="modal" data-target="#login_modal"><i class="fa fa-user-o"></i> Login</a> --}}
                            <a class="nav-link" href="{{ route('login.new5') }}"><i class="fa fa-user-o"></i> Login</a>
                            </li>

                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('merchant-signup') }}"><i class="ti ti-id-badge"></i> Merchant Signup</a>
                            </li>
                            @endguest
                            
                        </ul>
                        <!-- Search & Shop Btn Area -->
                        <div class="fancy-search-and-shop-area">
                            <a id="search-btn" href="#"><i class="icon_search" aria-hidden="true"></i></a>
                            <a id="shop-btn" href="#"><i class="icon_bag_alt" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="col-12 h-100">
                <div class="search-mobile text-center">
                    <form action="{{ route('search.product5') }}" method="post" class="search-form">
                        {{ csrf_field() }}
                        <div class="input-group grp-height">
                            <input type="search" name="search" placeholder="Search For Groceries, Fashion, Medicine">
                            <span class="input-group-addon">
                                <i class="fa fa-search">
                                    <input type="hidden" class="d-none" value="submit">
                                </i>
                                
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->