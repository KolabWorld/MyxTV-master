@extends('frontend.web-app')
{{-- Web site Title --}}
@section('title') MyxTV :: @parent @stop
@section('content')
    <section class="ptb-100 bg-image overflow-hidden" image-overlay="8">
        <div class="background-image-wraper" style="background: url('/assets/web/images/main-bg.jpg'); opacity: 1;"></div>
        <div class="hero-bottom-shape-two"
            style="background: url('/assets/web/images/slidershape.svg')no-repeat bottom center"></div>
        <div class="effect-1 opacity-1">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px"
                y="0px" viewBox="0 0 361.1 384.8" style="enable-background:new 0 0 361.1 384.8;" xml:space="preserve"
                class="injected-svg svg_img dark-color">
                <path
                    d="M53.1,266.7C19.3,178-41,79.1,41.6,50.1S287.7-59.6,293.8,77.5c6.1,137.1,137.8,238,15.6,288.9 S86.8,355.4,53.1,266.7z">
                </path>
            </svg>
        </div>
        <div class="container">
            <div
                class="row align-items-center justify-content-lg-between justify-content-md-center justify-content-sm-center">
                <div class="col-md-12 col-lg-6">
                    <div class="hero-slider-content text-white py-5">
                        <h1 class="text-white">Watch More. Earn More...</h1>
                        <p class="lead">MyX pays you to watch your favorite streamer. <br />
                            Watch 2 earn (W2E) is here!</p>

                        <div class="action-btns mt-4">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="#"
                                        class="d-flex align-items-center app-download-btn app-download-btn1 btn btn-brand-02 btn-rounded">
                                        <img src="/assets/web/images/app-store.png" />
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#"
                                        class="d-flex align-items-center app-download-btn app-download-btn2 btn btn-brand-02 btn-rounded">
                                        <img src="/assets/web/images/play-store.png" />
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6">
                    <div class="img-wrap">
                        <img src="/assets/web/images/main-app.png" alt="app image" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="promo-section ptb-100 position-relative overflow-hidden" id="WatchUrWay">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-10">
                    <div class="section-heading">
                        <h2>Watch Your Way to Success</h2>
                        <p>The next level of esports!</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                        <div class="card-body">
                            <div class="pb-2">
                                <span class=" icon-size-md color-secondary">
                                    <i class="fa fa-bell" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="pt-2 pb-3">
                                <h5>W2E</h5>
                                <p class="mb-0">Earn the $CX token for simply watching your favorite streamers.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                        <div class="card-body">
                            <div class="pb-2">
                                <span class=" icon-size-md color-secondary">
                                    <i class="fa fa-window-restore" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="pt-2 pb-3">
                                <h5>Rewards</h5>
                                <p class="mb-0">Trade your $CX token for rewards from some of the world’s biggest brands.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                        <div class="card-body">
                            <div class="pb-2">
                                <span class=" icon-size-md color-secondary">
                                    <i class="fa fa-repeat" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="pt-2 pb-3">
                                <h5>Events</h5>
                                <p class="mb-0">Keep up with esports events easily on MyX so you know exactly when to
                                    watch.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 single-promo-card single-promo-hover-2 p-2 mt-4">
                        <div class="card-body">
                            <div class="pb-2">
                                <span class=" icon-size-md color-secondary">
                                    <i class="fa fa-share-alt-square" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="pt-2 pb-3">
                                <h5>$CX</h5>
                                <p class="mb-0">W2E is just the beginning for the $CX token!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <div class="overflow-hidden">
        <section id="about" class="about-us ptb-100 background-shape-img position-relative">
            <div class="animated-shape-wrap">
                <div class="animated-shape-item"></div>
                <div class="animated-shape-item"></div>
                <div class="animated-shape-item"></div>
                <div class="animated-shape-item"></div>
                <div class="animated-shape-item"></div>
            </div>
            <div class="container">
                <div
                    class="row align-items-center justify-content-lg-between justify-content-md-center justify-content-sm-center">
                    <div class="col-md-12 col-lg-6 mb-5 mb-md-5 mb-sm-5 mb-lg-0">
                        <div class="about-content-left">
                            <h2>cxmmunity Help to Manage Everything for You</h2>
                            <p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters,
                                as opposed to using 'Content here, content here', making it look like readable English.</p>
                            <ul class="dot-circle pt-3">
                                <li>Lorem Ipsum is that it has a more-or-less normal distribution of letters</li>
                                <li>Lorem Ipsum is that it has a more-or-less normal distribution of letters.</li>
                                <li>Lorem Ipsum is that it has a more-or-less normal distribution of letters.</li>
                                <li>Lorem Ipsum is that it has a more-or-less normal distribution of letters. </li>
                                <li>Lorem Ipsum is that it has a more-or-less normal distribution of letters.</li>
                                <li>Lorem Ipsum is that it has a more-or-less normal distribution of letters.</li>
                            </ul>
                            <div class="row pt-3">
                                <div class="col-4 col-lg-3 border-right">
                                    <div class="count-data text-center">
                                        <h4 class="count-number mb-0 color-primary font-weight-bold">1023</h4>
                                        <span>Customers</span>
                                    </div>
                                </div>
                                <div class="col-4 col-lg-3 border-right">
                                    <div class="count-data text-center">
                                        <h4 class="count-number mb-0 color-primary font-weight-bold">5470</h4>
                                        <span>Downloads</span>
                                    </div>
                                </div>
                                <div class="col-4 col-lg-3 border-right">
                                    <div class="count-data text-center">
                                        <h4 class="count-number mb-0 color-primary font-weight-bold">3560</h4>
                                        <span>Satisfied</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5 col-md-5 col-lg-4">
                        <div class="about-content-right">
                            <a href="/pages/about-us"
                                class="d-flex align-items-center app-download-btn app-download-btn1 btn btn-brand-02 btn-rounded">
                                <img src="/assets/web/images/manage.png" alt="about us" class="img-fluid">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div> --}}

    {{-- <section class="position-relative feature-section py-5">
        <div class="container">
            <div
                class="row align-items-center justify-content-between justify-content-sm-center justify-content-md-center">
                <div class="col-sm-5 col-md-6 col-lg-6 mb-5 mb-md-5 mb-sm-5 mb-lg-0">
                    <div class="download-img">
                        <img src="/assets/web/images/usage.png" alt="download" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="feature-contents">
                        <h2>Manage your Apps usage easily</h2>
                        <p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as
                            opposed to using 'Content here, content here', making it look like readable English.</p>
                        <ul class="dot-circle pt-2">
                            <li>Content here, content here', making it look like readable English.</li>
                            <li>The point of using Lorem Ipsum is that it has a more-or-less normal distribution.</li>
                            <li>Content here, content here', making it look like readable English</li>
                            <li>The point of using Lorem Ipsum is that it has a more-or-less normal distribution.</li>
                        </ul>
                        <div class="action-btns mt-4">
                            <a href="#" class="btn btn-brand-02 mr-3">Download Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    
        <section class="feature-section pt-5 pb-100 bg-light" id="features">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-9 col-lg-9">
                        <div class="section-heading text-center mb-5">
                            <h2>MyX Features</h2>
                            <p>Take a look at how MyX helps you get paid to watch what you want online.</p>
                        </div>
                    </div>
                </div>
    
                <div class="row align-items-center justify-content-md-center">
                    <div class="col-lg-4 col-md-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex align-items-start mb-sm-0 mb-md-5 mb-lg-5">
                                    <img src="assets/web/images/icon-2.svg" alt="app icon" width="50"
                                        class="img-fluid mr-3">
                                    <div class="icon-text">
                                        <h5 class="mb-2">$CX Counter</h5>
                                        <p>View your $CX token earnings in real time.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-start mb-sm-0 mb-md-5 mb-lg-5">
                                    <img src="assets/web/images/timer.svg" alt="app icon" width="50"
                                        class="img-fluid mr-3">
                                    <div class="icon-text">
                                        <h5 class="mb-2">Watch Timer</h5>
                                        <p>Keep up with exactly how much content you have watched.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-start mb-sm-0 mb-md-5 mb-lg-5">
                                    <img src="assets/web/images/video.svg" alt="app icon" width="50"
                                        class="img-fluid mr-3">
                                    <div class="icon-text">
                                        <h5 class="mb-2">Intuitive Video Player</h5>
                                        <p>Seamlessly navigate your content with familiar controls.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 d-none d-sm-none d-md-block d-lg-block">
                        <div class="position-relative pb-md-5 py-lg-0">
                            <img alt="Image placeholder" src="assets/web/images/feature.png" class="img-center img-fluid">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex align-items-start mb-sm-0 mb-md-5 mb-lg-5">
                                    <img src="assets/web/images/market.svg" alt="app icon" width="50"
                                        class="img-fluid mr-3">
                                    <div class="icon-text">
                                        <h5 class="mb-2">Amazing Marketplace</h5>
                                        <p>Here’s where you trade your $CX watch2earn rewards for great prizes from top
                                            companies!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-start mb-sm-0 mb-md-5 mb-lg-5">
                                    <img src="assets/web/images/icon-8.svg" alt="app icon" width="50"
                                        class="img-fluid mr-3">
                                    <div class="icon-text">
                                        <h5 class="mb-2">Events</h5>
                                        <p>Keep up with esports events around the world so you know exactly when to watch and
                                            earn!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex align-items-start mb-sm-0 mb-md-5 mb-lg-5">
                                    <img src="assets/web/images/Wallet.svg" alt="app icon" width="50"
                                        class="img-fluid mr-3">
                                    <div class="icon-text">
                                        <h5 class="mb-2">Web3 Wallet</h5>
                                        <p>MyX gives you an easy to use web3 wallet so you can move into web3 at your own pace!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>   
    
    <section class="bg-image ptb-100" image-overlay="8">
        <div class="background-image-wraper"
            style="background: url('/assets/web/images/app-bg.jpg')no-repeat center center / cover fixed; opacity: 1;">
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <div class="section-heading text-center mb-1 text-white">
                        <h2 class="text-white">Download MyX</h2>
                        <p>MyX is available on the Apple and Google Play stores.</p>
                        <div class="action-btns">
                            <ul class="list-inline">
                                <li class="list-inline-item my-2">
                                    <a href="#"
                                        class="d-flex align-items-center app-download-btn btn btn-brand-02 btn-rounded">
                                        <span class=" icon-size-sm mr-3">
                                            <i class="fa fa-apple" aria-hidden="true"></i>
                                        </span>
                                        <div class="download-text text-left">
                                            <small>Download form</small>
                                            <h5 class="mb-0">App Store</h5>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-inline-item my-2">
                                    <a href="#"
                                        class="d-flex align-items-center app-download-btn btn btn-brand-02 btn-rounded">
                                        <span class=" icon-size-sm mr-3">
                                            <i class="fa fa-play" aria-hidden="true"></i>
                                        </span>
                                        <div class="download-text text-left">
                                            <small>Download form</small>
                                            <h5 class="mb-0">Google Play</h5>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="screenshots" class="screenshots-section ptb-100  ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <div class="section-heading text-center mb-5">
                        <h2>MyX Highlights</h2>
                        <p>Organize your watch time and rewards with just a few clicks.</p>
                    </div>
                </div>
            </div>
            <div class="screenshot-wrap">
                <div class="screenshot-frame"></div>
                <div class="screen-carousel owl-carousel owl-theme dot-indicator">
                    <img src="/assets/web/images/screen1.jpg" class="img-fluid" alt="screenshots" />
                    <img src="/assets/web/images/screen2.jpg" class="img-fluid" alt="screenshots" />
                    <img src="/assets/web/images/screen3.jpg" class="img-fluid" alt="screenshots" />
                    <img src="/assets/web/images/screen4.jpg" class="img-fluid" alt="screenshots" />
                    <img src="/assets/web/images/screen5.jpg" class="img-fluid" alt="screenshots" />
                </div>
            </div>
        </div>
    </section>

    <section id="pricing" class="pricing-section pb-100 bg-light pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <div class="section-heading text-center mb-4">
                        <h2>Vendor Subscription Plans</h2>
                        <p>
                            Choose from a variety of subscription programs to reach gamers across the globe in web2 and
                            web3.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-md-center justify-content-center">
                <div class="col-12">
                    <div class="d-flex justify-content-center text-center">
                        <label class="pricing-switch-wrap">
                            <span class="beforeinput year-switch text-success">
                                Monthly
                            </span>
                            <input type="checkbox" class="d-none" id="js-contcheckbox">
                            <span class="switch-icon"></span>
                            <span class="afterinput year-switch">
                                Yearly
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row plan-items align-items-center justify-content-md-center justify-content-center"
                id="plan-items">
            </div>
            <div class="row align-items-center justify-content-md-center justify-content-center">
                <div class="col-12">
                    <div class="support-cta text-center mt-5">
                        <h5 class="mb-1"><span class=" color-primary mr-3">
                                <i class="fa fa-headphones" aria-hidden="true"></i>
                            </span>We are Here to Help You
                        </h5>
                        <p>Have some questions?  <a href="mailto:info@cxmmunitymedia.co">Send us an
                                email</a> to
                            get in touch.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="position-relative gradient-bg ptb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-5 mb-4 mb-sm-4 mb-md-0 mb-lg-0">
                    <div class="testimonial-heading">
                        <h2>What Our Client Say About cxmmunity</h2>
                        <p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters,
                            Opposed to using Lorem Ipsum is that it has a more-or-less normal distribution of letters,
                            Opposed</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="testimonial-content-wrap">
                        <div class="owl-carousel owl-theme client-testimonial-1 dot-indicator testimonial-shape">
                            <div class="item">
                                <div class="testimonial-quote-wrap">
                                    <div class="media author-info mb-3">
                                        <div class="author-img mr-3">
                                            <img src="/assets/web/images/1.jpg" alt="client" class="img-fluid">
                                        </div>
                                        <div class="media-body text-white">
                                            <h5 class="mb-0 text-white">Aniket Kumar</h5>
                                            <span>Head Of Admin</span>
                                        </div>
                                        <i class="fa fa-quote-right" aria-hidden="true"></i>
                                    </div>
                                    <div class="client-say text-white">
                                        <p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution
                                            of letters, Opposed to using Lorem Ipsum is that it has a more-or-less normal
                                            distribution of letters, Opposed Lorem Ipsum is that it has a more-or-less
                                            normal distribution of letters, Opposed to</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testimonial-quote-wrap">
                                    <div class="media author-info mb-3">
                                        <div class="author-img mr-3">
                                            <img src="/assets/web/images/2.jpg" alt="client" class="img-fluid">
                                        </div>
                                        <div class="media-body text-white">
                                            <h5 class="mb-0 text-white">Anjana Sharma</h5>
                                            <span>HR Manager</span>
                                        </div>
                                        <!-- <i class="fas fa-quote-right text-white"></i> -->
                                        <i class="fa fa-quote-right" aria-hidden="true"></i>
                                    </div>
                                    <div class="client-say text-white">
                                        <p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution
                                            of letters, Opposed to using Lorem Ipsum is that it has a more-or-less normal
                                            distribution of letters, Opposed Lorem Ipsum is that it has a more-or-less
                                            normal distribution of letters, Opposed to</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="testimonial-quote-wrap">
                                    <div class="media author-info mb-3">
                                        <div class="author-img mr-3">
                                            <img src="/assets/web/images/3.jpg" alt="client" class="img-fluid">
                                        </div>
                                        <div class="media-body text-white">
                                            <h5 class="mb-0 text-white">Jimmy Shergill</h5>
                                            <span>Team Leader</span>
                                        </div>
                                        <!-- <i class="fas fa-quote-right text-white"></i> -->
                                        <i class="fa fa-quote-right" aria-hidden="true"></i>
                                    </div>
                                    <div class="client-say text-white">
                                        <p>The point of using Lorem Ipsum is that it has a more-or-less normal distribution
                                            of letters, Opposed to using Lorem Ipsum is that it has a more-or-less normal
                                            distribution of letters, Opposed Lorem Ipsum is that it has a more-or-less
                                            normal distribution of letters, Opposed to</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section id="faq" class="ptb-100 ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <div class="section-heading text-center mb-5">
                        <h2>Frequently Asked Questions (FAQ)</h2>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-12 col-lg-6 mb-5 mb-md-5 mb-sm-5 mb-lg-0">
                    <div class="img-wrap">
                        <img src="/assets/web/images/faq.svg" alt="download" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div id="accordion" class="accordion faq-wrap">
                        <div class="card mb-3">
                            <a class="card-header " data-toggle="collapse" href="#collapse0" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">Who is Cxmmunity?</h6>
                            </a>
                            <div id="collapse0" class="collapse show" data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>Cxmmunity is the company that powers MyX. We’re all about bringing esports to a wider audience. Join the Discord to get involved with the community, gaming tournaments, and much more!</p>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse1" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">How do I earn the $CX token?</h6>
                            </a>
                            <div id="collapse1" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>Simply sign up for a MyX account and starting watching content through the MyX app. You begin earning from the first second you watch.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card my-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse2" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">What rewards can I get with my $CX token?</h6>
                            </a>
                            <div id="collapse2" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>The MyX marketplace is always expanding. You never know what goodies might be in our store, so check back often!</p>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <a class="card-header collapsed" data-toggle="collapse" href="#collapse3" aria-expanded="false">
                                <h6 class="mb-0 d-inline-block">Do I need to know web3 to use MyX?</h6>
                            </a>
                            <div id="collapse3" class="collapse " data-parent="#accordion" style="">
                                <div class="card-body white-bg">
                                    <p>Nope! To use MyX, just start watching content through the app. You can learn the web3 stuff at your own pace!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="contact-us-section pb-100">
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-12 pb-3 message-box d-none">
                    <div class="alert alert-danger"></div>
                </div>
                {{-- <div class="col-md-12 col-lg-5 mb-5 mb-md-5 mb-sm-5 mb-lg-0">
                    <div class="contact-us-form gray-light-bg rounded p-5">
                        <h4>Ready to get started?</h4>
                        <form action="/submit/contact-form" method="post" id="contactForm" class="contact-us-form">
                            @csrf
                            <div class="form-row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') }}" placeholder="Enter name" required="required">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email') }}" placeholder="Enter email" required="required">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="mobile" class="form-control" name="mobile"
                                            value="{{ old('mobile') }}" placeholder="Enter mobile" required="required">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea name="message" id="message" class="form-control" rows="7" cols="25" placeholder="Message">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <button type="submit" data-request="ajax-submit" data-target="[role=post-data]"
                                        class="btn btn-brand-02" id="btnContactUs">
                                        Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> --}}
                <div class="col-md-12 col-lg-6">
                    <div class="contact-us-content">
                        {{-- <h2>Get Registration for Free</h2>
                        <p class="lead">Give us a call or drop by anytime, we endeavour to answer all enquiries within 24
                            hours on business days.</p>
                        <a href="#" class="btn btn-outline-brand-01 align-items-center">
                            Get Directions
                            <span class=" pl-2">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </span>
                        </a>
                        <hr class="my-5"> --}}
                        <ul class="contact-info-list">
                            <li class="d-flex pb-3">
                                <div class="contact-icon mr-3">
                                    <span class=" color-primary rounded-circle p-3">
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <div class="contact-text">
                                    <h5 class="mb-1">Company Location</h5>
                                    <p>
                                        1155 Perimeter Center West <br/> Suite 1100<br/>Atlanta, GA 30338
                                    </p>
                                </div>
                            </li>
                            <li class="d-flex pb-3">
                                <div class="contact-icon mr-3">
                                    <span class=" color-primary rounded-circle p-3">
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <div class="contact-text">
                                    <h5 class="mb-1">Email Address</h5>
                                    <p><a href="mailto:info@cxmmunitymedia.co">info@cxmmunitymedia.co</a></p>
                                </div>
                                
                            </li>
                            
                            
                            <hr/>
                            <li class="d-flex pb-3">
                                <div class="contact-text"> <br/>
                                    <h5 class="mb-1">Investors:</h5>
                                    <p>Learn about $CX tokenomics, market sustainability precautions, valuation justification and more in the <a href="https://myxesportstv.gitbook.io/myx/people/investors" target=_blank> MyX whitepaper
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('styles')
    <style type="text/css"></style>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            data = {
                'plan_type': 'monthly',
                '_token': '{{ csrf_token() }}'
            }
            $.ajax({
                url: '/ajax/subscription-plans',
                type: 'POST',
                data: data,
                success: function(data) {
                    if (data.code == 200) {
                        plandiv = '';
                        $.each(data.data, function(index, val) {
                            var price = '$' + val.price;
                            if (val.price == 0) {
                                price = 'Free';
                            }
                            plandiv += '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">';
                            plandiv +=
                                '<div class="text-center bg-white single-pricing-pack mt-4">';
                            plandiv += '<div class="py-4 border-0 pricing-header">';
                            plandiv +=
                                '<div class="price text-center mb-0 monthly-price color-secondary">' +
                                price + '</div></div>';
                            plandiv += '<div class="price-name">';
                            plandiv +=      '<h5 class="mb-0" style="text-transform: capitalize;">' + val.name + '</h5>';
                            plandiv +=      '<p class="mt-2 mb-0 font-weight-bold" style="text-transform: capitalize;"> Offers/Month : ' + val.offers_in_a_month + '</p>';
                            plandiv += '</div>';
                            plandiv += '<div class="pricing-content">';
                            plandiv += '<ul class="list-unstyled mb-4 pricing-feature-list">' +
                                val.description + '</ul>';
                            plandiv += '<a href="/vendor/registration/' + val.id +
                                '/subscription-plan" class="btn btn-outline-brand-02 btn-rounded mb-3" target="_blank">Purchase now</a>';
                            plandiv += '</div></div></div>';
                        });
                        $('#plan-items').html(plandiv);
                    }
                }
            });
        });

        $("#js-contcheckbox").change(function() {
            var plan_type = '';
            if (this.checked) {
                plan_type = 'yearly';
                $('.afterinput').addClass('text-success');
                $('.beforeinput').removeClass('text-success');
            } else {
                plan_type = 'monthly';
                $('.afterinput').removeClass('text-success');
                $('.beforeinput').addClass('text-success');
            }

            data = {
                'plan_type': plan_type,
                '_token': '{{ csrf_token() }}'
            }
            $.ajax({
                url: '/ajax/subscription-plans',
                type: 'POST',
                data: data,
                success: function(data) {
                    if (data.code == 200) {
                        plandiv = '';
                        $.each(data.data, function(index, val) {
                            var price = '$' + val.price;
                            if (val.price == 0) {
                                price = 'Free';
                            }
                            plandiv += '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">';
                            plandiv +=
                                '<div class="text-center bg-white single-pricing-pack mt-4">';
                            plandiv += '<div class="py-4 border-0 pricing-header">';
                            plandiv +=
                                '<div class="price text-center mb-0 monthly-price color-secondary">' +
                                price + '</div></div>';
                            plandiv += '<div class="price-name">';
                            plandiv +=      '<h5 class="mb-0" style="text-transform: capitalize;">' + val.name + '</h5>';
                            plandiv +=      '<p class="mt-2 mb-0 font-weight-bold" style="text-transform: capitalize;"> Offers/Month : ' + val.offers_in_a_month + '</p>';
                            plandiv += '</div>';
                            plandiv += '<div class="pricing-content">';
                            plandiv += '<ul class="list-unstyled mb-4 pricing-feature-list">' +
                                val.description + '</ul>';
                            plandiv += '<a href="/vendor/registration/' + val.id +
                                '/subscription-plan" class="btn btn-outline-brand-02 btn-rounded mb-3" target="_blank">Purchase now</a>';
                            plandiv += '</div></div></div>';
                        });
                        $('#plan-items').html(plandiv);
                    }
                }
            });
        });
    </script>
    <script type="text/javascript">
        function newsletterSubscribe() {

            var email = $('#emailforletter').val();
            var data = {
                'email': email,
                '_token': '{{ csrf_token() }}'
            }
            $.ajax({
                url: '/ajax/newsletter-subscribe',
                type: 'POST',
                data: data,
                timeout: 3000,
                success: function(msg) {
                    var msgHtml = $('#newsletter-response').html();
                    if (msg) {
                        msgHtml = msg;
                    }
                    $('#emailforletter').val('');
                    $('#newsletter-error-response').hide();
                    $('#newsletter-success-response').show();
                    $('#newsletter-success-response').html(msgHtml);

                },
                error: function(errors) {
                    var errors = errors.responseJSON;
                    var msgHtml = $('#newsletter-response').html();
                    if (errors) {
                        msgHtml = errors['errors']['email'];
                    }
                    $('#newsletter-success-response').hide();
                    $('#newsletter-error-response').show();
                    $('#newsletter-error-response').html(msgHtml);
                }
            });

            setTimeout(function() {
                $("#newsletter-error-response").hide();
                $("#newsletter-success-response").hide();
            }, 3000);
        }

        $('#subscribe').on('click', function() {
            // console.log('qwert');
            newsletterSubscribe();
        });
    </script>
@endsection
