<aside class="main-sidebar sidebar-dark-primary">
    <div class="text-center leftmenuaction mt-3">
        <a class="pt-2" href="/" role="button">
            <img src="/assets/admin/images/myx-logo.png" />
        </a>
        <a class="menucloico" data-widget="pushmenu" href="#" role="button">
            <img src="/assets/admin/images/close.svg" class="menu-cloepad" />
        </a>
    </div>
    <div class="sidebar">
        <nav class="mt-5">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link @if (isset($tab) && $tab == 'dashboard') active @endif">
                        <i class="nav-icon  icon-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if (!\Auth::user()->hasRoles(['vendor']))
                    <li class="nav-item">
                        <a href="/users" class="nav-link @if (isset($tab) && $tab == 'users') active @endif">
                            <i class="nav-icon icon-referals"></i>
                            <p>User Management</p>
                        </a>
                    </li>
                    <li
                        class="nav-item has-treeview 
                        @if (isset($tab) && in_array($tab, ['business-categories', 'vendors', 'vendor-origins'])) menu-open @endif
                        ">
                        <a href="#" class="nav-link">
                            <i class="nav-icon icon-customers"></i>
                            <p>
                                Vendor Management
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" @if (isset($tab) && in_array($tab, ['business-categories', 'vendors', 'vendor-origins'])) style="display: block" @endif>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'business-categories') active @endif"
                                    href="/business-categories">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Business Categories
                                    </p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'vendor-origins') active @endif"
                                    href="/vendor-origins">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Vendor Origins
                                    </p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'vendors') active @endif" href="/vendors">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Vendors
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="/banners" class="nav-link @if (isset($tab) && $tab == 'banners') active @endif">
                            <i class="nav-icon icon-customers"></i>
                            <p>Advertisement</p>
                        </a>
                    </li>
                    <li
                        class="nav-item has-treeview 
                        @if (isset($tab) && in_array($tab, ['event-types', 'events'])) menu-open @endif
                        ">
                        <a href="#" class="nav-link">
                            <i class="nav-icon icon-bookiings"></i>
                            <p>
                                Event Management
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" @if (isset($tab) && in_array($tab, ['event-types', 'events'])) style="display: block" @endif>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'event-types') active @endif"
                                    href="/event-types">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Event Types
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'events') active @endif" href="/events">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Events
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li
                    class="nav-item has-treeview 
                    @if (isset($tab) && in_array($tab, ['offer-types', 'offer-categories', 'premium-categories', 'marketplaces'])) menu-open @endif
                    ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon icon-promo"></i>
                        <p>
                            Marketplace
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" @if (isset($tab) && in_array($tab, ['offer-types', 'offer-categories', 'premium-categories', 'marketplaces'])) style="display: block" @endif>
                        @if (!\Auth::user()->hasRoles(['vendor']))
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'offer-types') active @endif"
                                    href="/offer-types">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Offer Types
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'offer-categories') active @endif"
                                    href="/offer-categories">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Offer Categories
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'premium-categories') active @endif"
                                    href="/premium-categories">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Premium Category
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link @if (isset($tab) && $tab == 'marketplaces') active @endif" href="/marketplaces">
                                <p>
                                    <i class="fas fa-caret-right mr-1"></i>
                                    Offers
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="nav-item has-treeview 
                    @if (isset($tab) && in_array($tab, ['subscription-plans', 'transaction-history'])) menu-open @endif
                    ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon icon-promo"></i>
                        <p>
                            Subscriptions
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" @if (isset($tab) && in_array($tab, ['subscription-plans', 'transaction-history'])) style="display: block" @endif>
                        @if (!\Auth::user()->hasRoles(['vendor']))
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'subscription-plans') active @endif"
                                    href="/subscription-plans">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Subscription Plans
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="/transaction-history"
                                class="nav-link  @if (isset($tab) && $tab == 'transaction-history') active @endif">
                                <p>
                                    <i class="fas fa-caret-right mr-1"></i>
                                    Payments
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/orders" class="nav-link @if (isset($tab) && $tab == 'orders') active @endif">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>Order Management</p>
                    </a>
                </li>
                @if (!\Auth::user()->hasRoles(['vendor']))
                    <li class="nav-item">
                        <a href="/contact-us" class="nav-link @if (isset($tab) && $tab == 'contact-us') active @endif">
                            <i class="nav-icon icon-customers"></i>
                            <p>Contact Us</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="/newsletter-subscriber"
                            class="nav-link @if (isset($tab) && $tab == 'newsletter-subs') active @endif">
                            <i class="nav-icon icon-customers"></i>
                            <p>NewsLetter Subscribers</p>
                        </a>
                    </li> --}}
                @endif
                <li
                    class="nav-item has-treeview 
                    @if (isset($tab) && in_array($tab, ['subscription-plans', 'transaction-history'])) menu-open @endif
                    ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon icon-promo"></i>
                        <p>
                            Support Management
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" @if (isset($tab) && in_array($tab, ['support-categories', 'support-sub-categories', 'supports'])) style="display: block" @endif>
                        @if (!\Auth::user()->hasRoles(['vendor']))
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'support-categories') active @endif"
                                    {{-- href="/support-categories"> --}}
                                    href="/support-categories">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Support Categories
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'support-sub-categories') active @endif"
                                    {{-- href="/support-sub-categories"> --}}
                                    href="/sub-categories">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Support Sub Categories
                                    </p>
                                </a>
                            </li> 
                        @endif
                        <li class="nav-item">
                            <a class="nav-link @if (isset($tab) && $tab == 'supports') active @endif" href="/supports">
                                <p>
                                    <i class="fas fa-caret-right mr-1"></i>
                                    Help & Support
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                @if (!\Auth::user()->hasRoles(['vendor']))
                    <li
                        class="nav-item has-treeview 
                    @if (isset($tab) &&
                        in_array($tab, ['countries', 'states', 'cities', 'static-content', 'pool-master', 'day-wise-pool-master', 'user-wallet'])) menu-open @endif
                    ">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-file-alt"></i>
                            <p>
                                Settings
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" @if (isset($tab) &&
                            in_array($tab, ['countries', 'states', 'cities', 'static-content', 'pool-master', 'day-wise-pool-master'])) style="display: block" @endif>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'user-wallet') active @endif"
                                    href="/user-wallets">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        User's Wallet
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'countries') active @endif"
                                    href="/countries">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Countries
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'states') active @endif" href="/states">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        States
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'cities') active @endif" href="/cities">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Cities
                                    </p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'price-views') active @endif" href="/price-views">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Price View
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'sponsers') active @endif" href="/sponsers">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Sponsers
                                    </p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="/static-contents"
                                    class="nav-link  @if (isset($tab) && $tab == 'static-content') active @endif">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Static Content
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'pool-master') active @endif"
                                    href="/pool-master/create">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Pool Master
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'day-wise-pool-master') active @endif"
                                    href="/day-wise-pool-master">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Day Wise Pool Master
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'plan-type') active @endif"
                                    href="/plan-type">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Plan Type
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'plan-name') active @endif"
                                    href="/plan-name">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Plan Name
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (isset($tab) && $tab == 'token-setting') active @endif"
                                    href="/token-setting/create">
                                    <p>
                                        <i class="fas fa-caret-right mr-1"></i>
                                        Token Setting
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
