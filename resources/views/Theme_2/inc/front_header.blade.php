<!-- header-area -->
 <header id="sticky-header" class="transparent-header header-style-two">
    <div class="container custom-container">
        <div class="heder-top-wrap">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="header-top-left">
                        <ul class="list-wrap">
                            <li><i class="flaticon-location"></i>{{ get_settings('website_address') ?: '-' }}</li>
                            <li><i class="flaticon-mail"></i><a href="mailto:{{ get_settings('admin_email') }}">
                                {{ get_settings('admin_email') ?: 'admin@admin.com' }}
                            </a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="header-top-right">
                        <div class="header-social">
                            <ul class="list-wrap">
                                @if(get_settings('social_facebook'))
                                    <li><a href="{{ get_settings('social_facebook') }}"><i class="fab fa-facebook-f"></i></a></li>
                                @endif

                                @if(get_settings('social_twitter'))
                                    <li><a href="{{ get_settings('social_twitter') }}"><i class="fab fa-twitter"></i></a></li>
                                @endif

                                @if(get_settings('social_insta'))
                                    <li><a href="{{ get_settings('social_insta') }}"><i class="fab fa-instagram"></i></a></li>
                                @endif

                                @if(get_settings('social_youtube'))
                                    <li><a href="{{ get_settings('social_youtube') }}"><i class="fab fa-youtube"></i></a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="header-top-btn">
                            @guest
                                <a href="{{ route('login') }}">
                                    <i class="flaticon-briefcase"></i> تسجيل / انشاء حساب
                                </a>
                            @else
                            <div class="dropdown">
                                <button class="dropdown-toggle user_dropdown" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i>
                                    {{ auth()->user()->name }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('my-account') }}">
                                            الرئيسية
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="document.getElementById('logout_account').submit()">
                                            تسجيل الخروج
                                        </a>
                                        <form id="logout_account" method="post" action="{{ route('logout') }}">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-area">
            <div class="row">
                <div class="col-12">
                    <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                    <div class="menu-wrap">
                        <nav class="menu-nav">
                            <div class="logo">
                                <a href="{{ url('/') }}"><img src="{{ $logo_url ?: asset('theme_2/front/assets/img/logo/logo.png') }}" alt="Logo"></a>
                            </div>
                            <div class="navbar-wrap main-menu d-none d-lg-flex">
                                <ul class="navigation">
                                    @php $current_page = isset($page) ? $page : null @endphp
                                    @forelse(ActivePagesMenus(['position','!=' , 'footer']) as $page)
                                        @if($page->position != 'hidden')
                                            @if($loop->iteration < 7)
                                                <li class="@if($current_page == $page) active @endif">
                                                    <a href="{{ url($page->slug) }}">
                                                        {{  $page->title }}
                                                    </a>
                                                </li>
                                            @elseif($loop->iteration >= 7)
                                                @if($loop->iteration == 7)
                                                    <li class="menu-item-has-children"><a href="#">صفحات أخرى</a>
                                                        <ul class="sub-menu">
                                                            <li class="@if($current_page == $page) active @endif"><a href="{{ url($page->slug) }}">{{ $page->title }}</a></li>
                                                @else
                                                    <li class="@if($current_page == $page) active @endif"><a href="{{ url($page->slug) }}">{{ $page->title }}</a></li>
                                                @endif

                                                @if($loop->last)
                                                    </ul>
                                                </li>
                                                @endif
                                            @endif
                                        @endif
                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                            <div class="header-action">
                                <ul class="list-wrap">
                                    <li class="header-contact-two">
                                        <div class="icon">
                                            <i class="flaticon-phone-call"></i>
                                        </div>
                                        <div class="content">
                                            <span>رقم الخط الساخن</span>
                                            <a href="tel:{{ get_settings('website_whastapp') }}">{{ get_settings('website_whastapp') ?: '-' }}</a>
                                        </div>
                                    </li>
                                    <li class="header-search"><a href="#"><i class="flaticon-search"></i></a></li>
                                    <li class="offcanvas-menu">
                                        <a href="#" class="menu-tigger">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>

                    <!-- Mobile Menu  -->
                    <div class="mobile-menu">
                        <nav class="menu-box">
                            <div class="close-btn"><i class="fas fa-times"></i></div>
                            <div class="nav-logo">
                                <a href="index.html"><img src="{{ asset('theme_2/front/assets/img/logo/logo.png') }}" alt="Logo"></a>
                            </div>
                            <div class="mobile-search">
                                <form action="#">
                                    <input type="text" placeholder="البحث عن ...">
                                    <button><i class="flaticon-search"></i></button>
                                </form>
                            </div>
                            <div class="menu-outer">
                                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                            </div>
                            <div class="social-links">
                                <ul class="clearfix list-wrap">
                                    @if(get_settings('social_facebook'))
                                        <li><a href="{{ get_settings('social_facebook') }}"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif

                                    @if(get_settings('social_twitter'))
                                        <li><a href="{{ get_settings('social_twitter') }}"><i class="fab fa-twitter"></i></a></li>
                                    @endif

                                    @if(get_settings('social_insta'))
                                        <li><a href="{{ get_settings('social_insta') }}"><i class="fab fa-instagram"></i></a></li>
                                    @endif

                                    @if(get_settings('social_youtube'))
                                        <li><a href="{{ get_settings('social_youtube') }}"><i class="fab fa-youtube"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <div class="menu-backdrop"></div>
                    <!-- End Mobile Menu -->

                </div>
            </div>
        </div>
    </div>

    <!-- header-search -->
    <div class="search-popup-wrap" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="search-close">
            <span><i class="fas fa-times"></i></span>
        </div>
        <div class="search-wrap text-center">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="title">... البحث هنا ...</h2>
                        <div class="search-form">
                            <form action="#">
                                <input type="text" name="search" placeholder="اكتب ما تريد البحث عنه">
                                <button class="search-btn"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header-search-end -->

    <!-- offCanvas-menu -->
    <div class="extra-info">
        <div class="close-icon menu-close">
            <button><i class="far fa-window-close"></i></button>
        </div>
        <div class="logo-side mb-30">
            <a href="{{ url('/') }}"><img src="{{ asset('theme_2/front/assets/img/logo/logo.png') }}" alt="Logo"></a>
        </div>
        <div class="side-info mb-30">
            <div class="contact-list mb-30">
                <h4>عنوان الشركة</h4>
                <p>{{ get_settings('website_address') }}</p>
            </div>
            <div class="contact-list mb-30">
                <h4>رقم جوال الشركة</h4>
                <p>{{ get_settings('website_whastapp') }}</p>
            </div>
            <div class="contact-list mb-30">
                <h4>البريد الالكترونى</h4>
                <p>{{ get_settings('admin_email') }}</p>
            </div>
        </div>
        <div class="social-icon-right mt-30">
            @if(get_settings('social_facebook'))
                <li><a href="{{ get_settings('social_facebook') }}"><i class="fab fa-facebook-f"></i></a></li>
            @endif

            @if(get_settings('social_twitter'))
                <li><a href="{{ get_settings('social_twitter') }}"><i class="fab fa-twitter"></i></a></li>
            @endif

            @if(get_settings('social_insta'))
                <li><a href="{{ get_settings('social_insta') }}"><i class="fab fa-instagram"></i></a></li>
            @endif

            @if(get_settings('social_youtube'))
                <li><a href="{{ get_settings('social_youtube') }}"><i class="fab fa-youtube"></i></a></li>
            @endif
        </div>
    </div>
    <div class="offcanvas-overly"></div>
    <!-- offCanvas-menu-end -->

</header>
<!-- header-area-end -->
