@extends('layouts.frontend.user')
@section('styles')
@stop
@section('content')

    <div class="container">
        <div class="row row_padding text_hover wow slideInLeft">
            <div class="col-12 col-lg-4 col-md-4 col-sm-6  brand">
                <img src="{{ asset('front/images/icon1.png') }}" alt="icon1" class="img-fluid mb-4 about_logo">
                <h6 class="font-weight mb-4 brandtext">Brand Identity</h6>
                <p class="text-justify">Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius isusto
                    odio dignissim qui blandit praesent.</p>
            </div>

            <div class="col-12 col-lg-4 col-md-4 col-sm-6   web">
                <img src="{{ asset('front/images/icon2.png') }}" alt="icon2" class="img-fluid mb-4 about_logo1">
                <h6 class="font-weight mb-4 webtext">Web Design & UI</h6>
                <p class="text-justify">Claritas est etiam processus dynamicus, qui sequitur mutationem lectorum autem vel
                    eum iriure dolor in.</p>
            </div>

            <div class="col-12 col-lg-4 col-md-4 col-sm-6   developement">
                <img src="{{ asset('front/images/icon3.png') }}" alt="icon3" class="img-fluid mb-4 about_logo2">
                <h6 class="font-weight mb-4 developementtext">Development & CMS</h6>
                <p class="text-justify">Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit
                    formas humanitatis per.</p>
            </div>
        </div>

    </div>
    <div class="background_color">
        <div class="container-fluid containerfluid">
            <div class="row">
                <div class="col-12 col-lg-6 col-md-12 col-sm-12 desingstudio wow slideInLeft">
                    <div class="figure about_img">
                        <img src="{{ asset('front/images/about_designstudio.png') }}" alt="furniture_image" class="img-fluid">
                    </div>
                </div>

                <div class="col-12 col-lg-6 col-md-12 col-sm-12 colset wow slideInRight">
                    <h3 class=" mb-4 mt-5">Some Words About Our Design Studio</h3>
                    <p class="text-justify">Mirum est notare quam littera gothica, quam nunc puta-mus parum claram,
                        anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.
                        Eodem modo typi, qui nunc nobis videntur.</p>
                    <button class="btn text-secondary  button_white mr-3 font-weight-bold mt-3" type="submit">OUR WORKS</button>
                </div>
            </div>
        </div>
    </div>
    <section class="MeetTeam_section">
        <div class="container">
            <div class="row row_padding">

                <div class="col-12 col-lg-4 col-md-6 col-sm-6 mb-2 wow bounceInLeft">

                    <h3>Meet The Team</h3>
                    <p class="mb-4">We Make Beautiful Things...</p>
                    <a href="#" class="about_imagehover">
                        <figure class="">
                            <img src="{{ asset('front/images/women1.jpg') }}" alt="women1_image" class="rounded-circle mr-2 mt-1 img_boxshadow" width="60" height="60">
                        </figure>
                        <div class="overlay"></div>
                    </a>

                    <a href="#">
                        <figure class="">
                            <img src="{{ asset('front/images/audiopost_men.png') }}" alt="men1_image" class="rounded-circle imghover mr-2 mt-1 img_boxshadow" width="60" height="60">
                        </figure>
                    </a>
                    <div class="overlay1"></div>
                    <a href="#">
                        <figure class="">
                            <img src="{{ asset('front/images/women2.png') }}" alt="women2_image" class="rounded-circle mr-2 mt-1 img_boxshadow" width="60" height="60">
                        </figure>
                    </a>
                    <div class="overlay2"></div>
                    <a href="#">
                        <figure class="">
                            <img src="{{ asset('front/images/audiopost_men1.png') }}" alt="men2_image" class="rounded-circle mr-2 mt-1 img_boxshadow" width="60" height="60">
                        </figure>
                    </a>
                    <div class="overlay3"></div>
                    <a href="#">
                        <figure class="">
                            <img src="{{ asset('front/images/men1.png') }}" alt="men3_image" class="rounded-circle mr-2 mt-2 img_boxshadow" width="60" height="60">
                        </figure>
                    </a>
                    <div class="overlay4"></div>
                    <a href="#">

                        <figure class="">
                            <img src="{{ asset('front/images/women3.png') }}" alt="women3_image" class="rounded-circle mt-2 img_boxshadow" width="60" height="60">
                        </figure>
                    </a>
                    <div class="overlay5"></div>

                </div>

                <div class="col-12 col-lg-4 col-md-6 col-sm-6 about_img_margin  about_res_imgmargin text-center mt-lg-5 mt-md-0 mt-sm-0 wow flash">

                    <div class="figure about_figure">
                        <img src="{{ asset('front/images/about_men.jpg') }}" alt="about_men_image" class="img-fluid mr-2 ">

                    </div>
                </div>
                <div class="col-12 col-lg-4 col-md-6 col-sm-12 mb-2  mt-5 mt-lg-0 mt-md-3 mt-sm-0 about_res_imgmargin wow bounceInRight">
                    <h6 class="h6font18 cursor_line">Chris Richards</h6>
                    <p class="stdpost_para">Marketing Envato Pvt Ltd.</p>
                    <p  class="text-justify">Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum
                        formas humanitatis per seacula quarta decima et.</p>

                    <h6 class="socialmedia_icon mt-4">
                        <a href="#"><i class="fa fa-facebook  mr-3 textcolor"></i></a>
                        <a href="#"><i class="fa fa-twitter mr-3 textcolor"></i></a>
                        <a href="#"><i class="fa fa-google-plus  mr-3 textcolor"></i></a>
                        <a href="#"><i class="fa fa-pinterest-p mr-3 textcolor" aria-hidden="true"></i></a>
                    </h6>

                </div>
            </div>

        </div>
    </section>
    <div class="backgroundcolor1">
        <div class="container">
            <div class="row carousel_row_padding mt-5 mt-lg-0 mt-md-0 mt-sm-0">
                <div class="col-12 col-lg-12 col-md-12 col-sm-12 ">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active text-center">
                                <h3>Our Customers Say</h3>
                                <img src="{{ asset('front/images/stdpost_quoteicon.png') }}" alt="quote_image">
                                <h5 class="stdpost_fontsetting">Qodem modo typi, qui nunc nobis videntur
                                    parum clari, fiant</h5>
                                <h5 class="stdpost_fontsetting">sollemnes in futurum
                                    quam nunc parum nunc putamus claram</h5>
                                <h5 class="stdpost_fontsetting">mazim placerat facer possim assum.</h5>
                                <h5 class=" h5font18 text-primary cursor_line mt-4">David Miller</h5>
                                <p class="text-secondary stdpost_para">Marketing Envato Pvt.Ltd.</p>
                            </div>
                            <div class="carousel-item text-center">
                                <h3>Our Customers Say</h3>
                                <img src="{{ asset('front/images/stdpost_quoteicon.png') }}" alt="quote_image">
                                <h5 class="stdpost_fontsetting">Qodem modo typi, qui nunc nobis videntur
                                    parum clari, fiant</h5>
                                <h5 class="stdpost_fontsetting">sollemnes in futurum quam nunc parum nunc putamus claram</h5>
                                <h5 class="stdpost_fontsetting">mazim placerat facer possim assum.</h5>
                                <h5 class="h5font18 text-primary  cursor_line mt-4">Loius Donald</h5>
                                <p class="text-secondary stdpost_para">Marketing Envato Pvt.Ltd.</p>
                            </div>
                            <div class="carousel-item text-center">
                                <h3>Our Customers Say</h3>
                                <img src="{{ asset('front/images/stdpost_quoteicon.png') }}" alt="quote_image">
                                <h5 class="stdpost_fontsetting">Qodem modo typi, qui nunc nobis videntur
                                    parum clari, fiant</h5>
                                <h5 class="stdpost_fontsetting">sollemnes in futurum quam nunc parum nunc putamus claram</h5>
                                <h5 class="stdpost_fontsetting">mazim placerat facer possim assum.</h5>
                                <h5 class="h5font18 text-primary cursor_line mt-4">John Meck</h5>
                                <p class="text-secondary stdpost_para">Marketing Envato Pvt.Ltd.</p>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span> <img src="{{ asset('front/images/back.png') }}" alt="previous_page"  class="mr-3 previmg" id="sponser3a" height="22" width="15"></span>
                            <span class="sr-only">Previous</span>
                        </a>

                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span> <img src="{{ asset('front/images/right2.png') }}" alt="next_page"  class="ml-3 nextimg" id="sponser4a" height="22" width="15"></span>
                            <span class="sr-only">next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="logo-section">
        <div class="container">
            <div class="row rowpadding1 text-center about_row_margin">
                <div class="col-12 col-lg-3 col-md-3 col-sm-12  wow rotateIn mt-4 mb-3">
                    <img src="{{ asset('front/images/logo_1.png') }}" alt="barber_logo" class="img-fluid  about_logo">
                </div>
                <div class="col-12 col-lg-3 col-md-3 col-sm-12  adjust_space wow rotateIn mt-4 mb-3">
                    <img src="{{ asset('front/images/logo_2.png') }}" alt="Delicious_logo" class="img-fluid about_logo">
                </div>
                <div class="col-12 col-lg-3 col-md-3 col-sm-12 adjust_space  wow rotateIn mt-4 mb-3">
                    <img src="{{ asset('front/images/logo_3.png') }}" alt="Designer_logo" class="img-fluid about_logo">
                </div>
                <div class="col-12 col-lg-3 col-md-3 col-sm-12  adjust_space  wow rotateIn mt-4  ">
                    <img src="{{ asset('front/images/logo_4.png') }}" alt="Royal_logo"  class="img-fluid about_logo">
                </div>
            </div>
        </div>
    </section>
@stop
@section('scripts')
    <script src="{{ asset('front/vendors/isotope/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('front/vendors/imagesloaded/js/imagesloaded.pkgd.js') }}"></script>
    <script src="{{ asset('front/js/home.js') }}"></script>
    <script>
        new WOW().init();

    </script>
@stop
