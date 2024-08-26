<footer class="footer-1 gradient-bg ptb-60 footer-with-newsletter">
    {{-- <div class="container">
        <div class="row newsletter-wrap primary-bg rounded shadow-lg p-5">
            <div class="col-md-6 col-lg-7 mb-4 mb-md-0 mb-sm-4 mb-lg-0">
                <div class="newsletter-content text-white">
                    <h3 class="mb-0 text-white">Subscribe our Newsletter</h3>
                    <p class="mb-0">We’re a team of non-cynics who truly care for our work.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-5">
                <form class="newsletter-form position-relative">
                    <input type="text" class="input-newsletter form-control" placeholder="Enter your email"  id="emailforletter" name="email">
                    <button type="button" id="subscribe" class="btn btn-warning btn-newwarning"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                </form>
                <label class="text-danger" id="newsletter-error-response"  for="newsletter-response" style="position:absolute"></label>
                <label class="text-success" id="newsletter-success-response"  for="newsletter-response" style="position:absolute"></label>
            </div>
        </div>
    </div> --}}

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-4 mb-4 mb-md-4 mb-sm-4 mb-lg-0">
                <a href="#" class="navbar-brand mb-2">
                    <img src="/assets/web/images/myx-logo-white.png" alt="logo" width="80px" class="img-fluid">
                </a>
                <br>
                {{-- <p>MyX will bring the next 1 billion gamers and buidlers into web3 with the sponsors to invest in their
                    success.
                    Cxmmunity is the premier company in American college esports. Cxmmunity has proven its ability to
                    sustainably uplift underserved gaming communities in web2 through positioning with A-list sponsors,
                    offering unique value to partners, and responsibly investing profits into sustainable solutions.
                </p> --}}
                <div class="list-inline social-list-default background-color social-hover-2 mt-2">
                    <li class="list-inline-item"><a class="twitter" href="https://www.facebook.com/Cxmmunity/" target="_blank"><img
                                src="/assets/web/images/fb.svg" /></a></li>
                    <li class="list-inline-item"><a class="twitter" href="https://instagram.com/cxmmunity.co" target="_blank"><img
                                src="/assets/web/images/inst.svg" /></a></li>
                    <li class="list-inline-item"><a class="twitter" href="https://discord.gg/cxmmunity" target="_blank"><img
                                src="/assets/web/images/discord.svg" /></a></li>
                    <li class="list-inline-item"><a class="twitter" href="https://twitter.com/cxmmunity" target="_blank"><img
                                src="/assets/web/images/tw.svg" /></a></li>
                    <li class="list-inline-item"><a class="twitter" href="https://twitch.tv/cxmmunity" target="_blank"><img
                                src="/assets/web/images/twitch.svg" /></a></li>
                    <li class="list-inline-item"><a class="twitter" href="https://youtube.com/cxmmunity" target="_blank"><img
                                src="/assets/web/images/yt.svg" /></a></li>

                </div>
            </div>
            <div class="col-md-12 col-lg-8">
                <div class="row mt-0">
                    {{-- <div class="col-sm-6 col-md-3 col-lg-3 mb-4 mb-sm-4 mb-md-0 mb-lg-0">
                        <h6 class="text-uppercase">
                            Quick Links
                        </h6>
                        <ul>
                            <li>
                                <a href="#">About</a>
                            </li>
                            <li>
                                <a href="#">Features</a>
                            </li>
                            <li>
                                <a href="#">Faqs</a>
                            </li>
                            <li>
                                <a href="#">Contact</a>
                            </li>
                        </ul>
                    </div> --}}
                    {{-- <div class="col-sm-6 col-md-4 col-lg-4 mb-4 mb-sm-4 mb-md-0 mb-lg-0">
                        <h6 class="text-uppercase">
                            App Features
                        </h6>
                        <ul>
                            <li>
                                <a href="#">$CX Counter</a>
                            </li>
                            <li>
                                <a href="#">Watch Timer</a>
                            </li>
                            <li>
                                <a href="#">Intuitive Video Player</a>
                            </li>
                            <li>
                                <a href="#">Amazing Marketplace</a>
                            </li>
                            <li>
                                <a href="#">Events</a>
                            </li>
                            <li>
                                <a href="#">Web3 Wallet</a>
                            </li>
                        </ul>
                    </div> --}}
                    <div class="col-sm-4 col-md-4 col-lg-4 mb-4 mb-sm-4 mb-md-0 mb-lg-0">
                        <h6 class="text-uppercase">
                            Subscription plans 
                        </h6>
                        <ul>

                            @foreach($plans as $plan)
                            <li>
                                <a href="#pricing">{{$plan->name}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">

                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <h6 class="text-uppercase">Support</h6>
                        <ul>
                            {{-- <li>
                                <a href="#">Security</a>
                            </li> --}}
                            <li>
                                <a href="/pages/about-us" >About Us</a>
                            </li>
                            <li>
                                <a href="/pages/terms-condition">Terms and Conditions</a>
                            </li>
                            <li>
                                <a href="/pages/privacy-policy">Privacy Policy</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="footer-bottom py-3 gray-light-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="copyright-wrap small-text">
                    <p class="mb-0">&copy;  Copyright 2023 MyxTV Media. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="scroll-top scroll-to-target primary-bg text-white" data-target="html">
    <span class="">
        <i class="fa fa-hand-o-up" aria-hidden="true"></i>
    </span>
</div>
