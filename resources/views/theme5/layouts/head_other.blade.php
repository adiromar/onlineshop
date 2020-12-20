

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

<!-- ***** Header Area Start ***** -->
<header class="header_area" id="header">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-12 h-100">
                <nav class="h-100 navbar navbar-expand-lg align-items-center">
                    <!-- <a class="navbar-brand" href="index.html">fancy</a> -->
                <a href="{{ url('/') }}"><img class="navbar-brand" src="{{ asset('themes/5/logos/CS_logo.png') }}" alt="Fatafat logo" width="135" height="70"></a>

                    <div class="deliveryMode">
                        <form action="">
                            <div class="row">
                                <div class="col-lg-4">
                                    <select name="" id="" class="form-control">
                                        <option>Home Delivery</option>
                                        <option>Take Away</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-lg-2">
                                    <button class="locate-btn">Locate Me</button>
                                </div>
                            </div>
                            
                            
                            
                        </form>
                    </div>
                    
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#fancyNav" aria-controls="fancyNav" aria-expanded="false" aria-label="Toggle navigation"><span class="ti-menu"></span></button>
                    <div class="collapse navbar-collapse" id="fancyNav">
                        <ul class="navbar-nav ml-auto">
                           
                            <li class="nav-item">
                                <a class="nav-link" id="search-btn" href="#"><i class="fa fa-search"></i></i> Search</a>
                            </li>
                            
                            @guest
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#login_modal"><i class="fa fa-user-o"></i> Login</a>
                            </li>
                            @endguest
                            
                            @auth
                                {{-- <li>
                                    <a href="" class="nav-link" >Welcome, {{ Auth()->user()->username}}</a>
                                </li> --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth()->user()->username}}</a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ url('/admin') }}">Admin</a>
                                    
                                        <a class="dropdown-item" href="#">Profile</a>
                                        <a class="dropdown-item" href="#">Orders</a>
                                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{csrf_field()}}
                                    </form>
                                    </div>
                                </li>

                            @endauth
                        </ul>
                        <!-- Search & Shop Btn Area -->
                        <div class="fancy-search-and-shop-area">
                            <a id="search-btn" href="#"><i class="icon_search" aria-hidden="true"></i></a>
                            <a id="shop-btn" href="#"><i class="icon_bag_alt" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->