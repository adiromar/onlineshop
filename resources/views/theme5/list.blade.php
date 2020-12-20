@extends('theme5.layouts.main_other')

{{-- @yield('modals') --}}


@section('content')
    <div class="p-70">
        
        <div class="bg-img">
            <div class="containermain">
    

                @php
                    $slides = App\Sliders::latest()->where('showSlider', 1)->get()->take(6);
                @endphp
                @if( count($slides) > 0)
                
                    
                <div class="owl-main owl-carousel owl-theme">
                    @foreach ($slides as $slide)
                    <div class="item"><img src="{{ 'uploads/sliders/' . $slide->sliderImage }}" alt="" ></div>
                    @endforeach
                </div>
                
                @else

                <div class="owl-main owl-carousel owl-theme">
                    <div class="item"><img src="{{ asset('themes/5/img/slider_1.jpg') }}" alt="" ></div>
                    <div class="item"><img src="{{ asset('themes/5/img/slider_2.jpg') }}" alt="" ></div>
                    <div class="item"><img src="{{ asset('themes/5/img/slider_3.jpg') }}" alt="" ></div>
                    <div class="item"><img src="{{ asset('themes/5/img/slider_4.jpg') }}" alt="" ></div>
                    <div class="item"><img src="{{ asset('themes/5/img/slider_5.png') }}" alt="" ></div>
                </div>

                @endif
    
            </div>
        </div>
    
        <div class="container pt-4 pb-4">
            
                
                <div class="slick-main">
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/burger.png') }}" class="filter-cat" data-cat_id="all">
                        <div class="nameDiv"><span>All</span></div>
                    </div>

                    @if( $category = App\Category::latest()->get() )
                    <?php //dd($category); ?>
                    @foreach ($category as $cat)
                        <div class="slider-div">
                        <img src="{{ asset('/' . $cat->image) }}" class="filter-cat" data-cat_id="{{ $cat->id }}">
                            <div class="nameDiv"><span>{{ $cat->name }}</span></div>
                        </div>
                    @endforeach
                    

                    @else

                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/burger.png') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/burger.png') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/burger.png') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/burger.png') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/burger.png') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/burger.png') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/burger.png') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/burger.png') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>
    
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/books.jpg') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/books.jpg') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/car.png') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/car.png') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/pills.png') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>
                    <div class="slider-div">
                        <img src="{{ asset('themes/5/img/pills.png') }}">
                        <div class="nameDiv"><span>Restaurants</span></div>
                    </div>

                    @endif
                    
                </div>
    
    
                <div class="row mt-5" id="vendor-data">
                    @if($suppliers = App\Supplier::get() )
                        @foreach ($suppliers as $supplier)

                        <div class="col-lg-4 col-md-12 mb-3">
                            <div class="card card-main">
                                <div class="card-inner">
                                    <div class="card-image">
                                        <img src="{{ asset($supplier->image) }}" class="card-image-view">
        
                                        <p class="closed-tag">Closed</p>
                                    </div>
                                    <div class="card-right">
                                        <div class="card-heading">
                                        <span class="v-link"><a href="{{ route('vendor.store', $supplier->user_id) }}">{{ $supplier->detail }}</a></span>
                                        </div>
                                        <div class="card-info">
                                            <p>{{ $supplier->address }}</p>
                                        </div>
                                        <div class="card-description">
                                            <p>No Rating Yet</p>
                                        </div>
        
                                        <div class="viewmenu">
                                            <a href="{{ route('vendor.store', $supplier->user_id) }}">View Menu <i class="fa fa-angle-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    @else
                    <div class="col-lg-4 col-md-12 mb-3">
                        <div class="card card-main">
                            <div class="card-inner">
                                <div class="card-image">
                                    <img src="{{ asset('themes/5/img/ansari.jpg') }}" class="card-image-view">
    
                                    <p class="closed-tag">Closed</p>
                                </div>
                                <div class="card-right">
                                    <div class="card-heading">
                                        <span>Bombay Halal..</span>
                                    </div>
                                    <div class="card-info">
                                        <p>4.22 km - Sukhdev Market</p>
                                    </div>
                                    <div class="card-description">
                                        <p>No Rating Yet</p>
                                    </div>
    
                                    <div class="viewmenu">
                                        <a href="">View Menu <i class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-lg-4 col-md-12 mb-3">
                        <div class="card card-main">
                            <div class="card-inner">
                                <div class="card-image">
                                    <img src="{{ asset('themes/5/img/medicine.jpg') }}" class="card-image-view">
                                    <p class="closed-tag">Closed</p>
                                </div>
                                <div class="card-right">
                                    <div class="card-heading">
                                        <span>Bombay Halal..</span>
                                    </div>
                                    <div class="card-info">
                                        <p>4.22 km - Sukhdev Market</p>
                                    </div>
                                    <div class="card-description">
                                        <p>No Rating Yet</p>
                                    </div>
    
                                    <div class="viewmenu">
                                        <a href="">View Menu <i class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 mb-3">
                        <div class="card card-main">
                            <div class="card-inner">
                                <div class="card-image">
                                    <img src="{{ asset('themes/5/img/meat_b.jpg') }}" class="card-image-view">
    
                                    <p class="closed-tag">Closed</p>
                                </div>
                                <div class="card-right">
                                    <div class="card-heading">
                                        <span>Bombay Halal..</span>
                                    </div>
                                    <div class="card-info">
                                        <p>4.22 km - Sukhdev Market</p>
                                    </div>
                                    <div class="card-description">
                                        <p>No Rating Yet</p>
                                    </div>
    
                                    <div class="viewmenu">
                                        <a href="">View Menu <i class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
    
                </div>
            
        </div>
    </div>
@endsection