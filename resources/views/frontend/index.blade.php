@extends('layouts.frontend.user')
@section('styles')
@stop
@section('content')
    <div class="container">
        <section class="home">
            <div class="container" id="container">
                <div class="row">
                    <div class="col-12 py-3 mt-4">
                        <div class="home_filter-menu-group1">
                            <ul class="list-inline">
                                <li class="list-inline-item  mr-5 sub-menu_icon sub-menu_icon1"><img src="{{ asset('front/images/grey_submenuicon.png') }}" alt="submenu-icon"></li>
                                <li class="active list-inline-item all mr-4 mb-2 li-item li-all" data-filter="*">ALL</li>
                                <li class="list-inline-item  mr-4 mb-2 brand li-item" data-filter=".brand">BRANDING</li>
                                <li class="list-inline-item  mr-4 mb-2 user li-item" data-filter=".user">UI/UX</li>
                                <li class="list-inline-item  mr-4 mb-2 present li-item" data-filter=".present">PRESENTATION</li>
                                <li class="list-inline-item  mr-4 mb-2 print li-item" data-filter=".print">PRINT</li>
                                <li class="list-inline-item  mr-3 mb-2 web li-item" data-filter=".web">WEB DEVELOPEMENT</li>
                            </ul>
                        </div>
                        <div class="home_icon">
                            <img src="{{ asset('front/images/index_icon.png') }}" class="menu_toggle_icon1" alt="submenu-icon">
                        </div>
                    </div>
                </div>
                <div class="portfolio3">
                    <div class="grid">
                        <div class="grid-sizer"></div>
                        <div class="grid-item grid-item--width4 grid-item--height wow slideInLeft">
                            <a href="#">
                                <figure class="imghvr-fade">
                                    <img src="{{ asset('front/images/home_businesscard.png') }}"  alt="businesscard" class="img-fluid">
                                    <figcaption class="porfolio3_figcaption1 text-center">
                                        <h6>Business Card</h6>
                                        <p class="font16 home_text-color">User, Identity</p>
                                    </figcaption>
                                </figure>
                            </a>

                        </div>
                        <div class="grid-item grid-item--width2 grid-item--height2   user web wow slideInLeft">

                            <a href="#">
                                <figure class="imghvr-fade">
                                    <img src="{{ asset('front/images/home_ipad.jpg') }}" alt="ipad" class="img-fluid">
                                    <figcaption class="porfolio3_figcaption6 text-center">
                                        <h6>IPAD</h6>
                                        <p class="font16  home_text-color">Web Developement,Identity</p>
                                    </figcaption>
                                </figure>
                            </a>

                        </div>
                        <div class="grid-item  grid-item--height3 present  print wow slideInRight">
                            <a href="#">
                                <figure class="imghvr-fade">
                                    <img src="{{ asset('front/images/home_iphone.png') }}" alt="iphone" class="img-fluid">
                                    <figcaption class="porfolio3_figcaption5 text-center">
                                        <h6>IPHONE</h6>
                                        <p class="font16  home_text-color">Presentation,Identity</p>
                                    </figcaption>
                                </figure>
                            </a>

                        </div>


                        <div class="grid-item grid-item--width6 grid-item--height4 present web wow slideInRight">
                            <a href="#">
                                <figure class="imghvr-fade">
                                    <img src="{{ asset('front/images/home_notebook1.png') }}" alt="notebook" class="img-fluid">
                                    <figcaption class="porfolio3_figcaption2 text-center">
                                        <h6>NOTEBOOK</h6>
                                        <p class="font16  home_text-color">Presentation, Identity</p>
                                    </figcaption>
                                </figure>
                            </a>

                        </div>
                        <div class="grid-item   grid-item--height5 user brand present wow slideInLeft">
                            <a href="#">
                                <figure class="imghvr-fade">
                                    <img src="{{ asset('front/images/home_bag.png') }}" alt="fabric_bag" class="img-fluid">
                                    <figcaption class="porfolio3_figcaption7 text-center">
                                        <h6>FABRIC-BAG</h6>
                                        <p class="font16  home_text-color">Brand, Identity</p>
                                    </figcaption>
                                </figure>
                            </a>

                        </div>
                        <div class="grid-item  grid-item--height6  mdsetting wow slideInDown">
                            <a href="#">
                                <figure class="imghvr-fade">
                                    <img src="{{ asset('front/images/home_paperbrand2.png') }}" alt="paperbrand" class="img-fluid">
                                    <figcaption class="porfolio3_figcaption3 text-center">
                                        <h6>PAPER PRESENTATION</h6>
                                        <p class="font16  home_text-color">Branding, Identity</p>
                                    </figcaption>
                                </figure>
                            </a>

                        </div>

                        <div class="grid-item grid-item--width2 grid-item--height4 print brand wow slideInRight">
                            <a href="#">
                                <figure class="imghvr-fade">
                                    <img src="{{ asset('front/images/home_laptop.png') }}" alt="laptop"  class="img-fluid">
                                    <figcaption class="porfolio3_figcaption4 text-center">
                                        <h6>LAPTOP</h6>
                                        <p class="font16  home_text-color">Print, Identity</p>
                                    </figcaption>
                                </figure>
                            </a>

                        </div>
                        <div class="grid-item  grid-item--height3 wow slideInLeft">
                            <a href="#">
                                <figure class="imghvr-fade">
                                    <img src="{{ asset('front/images/home_appscreen.png') }}" alt="appscreen" class="img-fluid">
                                    <figcaption class="porfolio3_figcaption8 text-center">
                                        <h6>APP SCREEN</h6>
                                        <p class="font16 home_text-color">Web developement, Identity</p>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center mt-5">
                        <button class="btn btn-primary  button_primary font-weight-bold mt-2 mb-5">LOAD MORE</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@section('scripts')
    <script src="{{ asset('front/vendors/isotope/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('front/vendors/imagesloaded/js/imagesloaded.pkgd.js') }}"></script>
    <script src="{{ asset('front/js/home.js') }}"></script>
    <script>
        new WOW().init();

    </script>
    @stop
