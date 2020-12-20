   <!-- ***** Breadcumb Area Start ***** -->
   <div class="fancy-breadcumb-area bg-imgg bg-overlayy fancy-hero-bg">
    <div class="main-lay" style="">

    <div class="containers">
        <div class="row align-items-center">
            <div class="col-12">
                <?php $slides = App\Sliders::latest()->where('showSlider', 1)->get()->take(3); ?>

                <div class="slick-home" src='{"slidesToShow": 1, "slidesToScroll": 1}'>
                    @if( count($slides) )
                    @foreach ($slides as $slide)
                        <div>
                            <img data-lazy="{{ 'uploads/sliders/' . $slide->sliderImage }}" class="img-responsive"></div>
                    @endforeach

                    @else
                <div><img data-lazy="https://picsum.photos/1200/450?grayscale" class="img-responsive"></div>
                    @endif

                  </div>


                {{-- <div class="breadcumb-content text-center"> --}}
                    {{-- <h2>Your Full Time Delivery Partner</h2> --}}
                    {{-- <h5 class="text-white">Order anything of your choice!</h5> --}}
                    <!-- Breadcumb -->

                    {{-- <form action="/list">
                        <div class="row mt-5">
                            <div class="col-lg-3 col-12 ">

                            </div>

                            <div class="col-lg-5 col-12 search_row">
                                <i class="fa fa-map-marker class_map"></i>
                                <input type="text" name="" placeholder="Please Select a location" class="form-control">

                            <div class="aim-div">
                                <span>
                                    <img src="{{ asset('themes/5/img/aim.svg') }}">
                                </span>
                            </div>

                            </div>
                            <div class="col-lg-4 col-12 ">
                                <button class="order_button">Order Now</button>
                            </div>
                        </div>


                    </form> --}}

                {{-- </div> --}}
            </div>
        </div>
    </div>

    </div>
</div>
<!-- ***** Breadcumb Area End ***** -->
