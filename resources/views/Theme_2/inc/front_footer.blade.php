<!-- footer-area -->
<footer>
    <div class="footer-area-two footer-bg-two" data-background="{{ asset('theme_2/assets/img/bg/h2_footer_bg.jpg') }}">
        <div class="footer-top-two">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-7">
                        <div class="footer-widget">
                            <div class="fw-logo">
                                <a href="index.html">
                                    <img src="{{ asset('theme_2/front/assets/img/logo/logo.png') }}" alt="" style="max-height: 100px;">
                                </a>
                            </div>
                            <div class="footer-content">
                                <p>
                                    متخصصون في التطوير الاداري وتقديم الاستشارات للقطاع الخاص والقطاع غير الربحي.
                                </p>
                                <div class="footer-info">
                                    <ul class="list-wrap">
                                        <li>
                                            <div class="icon">
                                                <i class="flaticon-phone-call"></i>
                                            </div>
                                            <div class="content">
                                                <a href="tel:0123456789">{{ get_settings('website_whastapp') }}</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon">
                                                <i class="flaticon-clock"></i>
                                            </div>
                                            <div class="content">
                                                <p>{{ get_settings('website_address') }}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-6">
                        <div class="footer-widget">
                            <h4 class="fw-title">القائمة</h4>
                            <div class="footer-link">
                                <ul class="list-wrap">
                                    @forelse(ActivePagesMenus(['position','!=' , 'header']) as $page)
                                        @if($page->position != 'hidden')
                                            <li>
                                                <a href="{{ url($page->slug) }}">
                                                    {{  $page->title }}
                                                </a>
                                            </li>
                                        @endif
                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-7">
                        <div class="footer-widget">
                            <h4 class="fw-title">نشرتنا البريدية</h4>
                            <div class="footer-newsletter">
                                <p>
                                    يمكنك الاشتراك فى خدمة نشرتنا البريدة ليصلك كل جديد عن خدماتنا و انشطتنا الحديثة و القادمة
                                </p>
                                <form method="post" action="{{ url('send-news-letter') }}">
                                    @csrf
                                    <input type="email" name="email" placeholder="enter your e-mail">
                                    <button type="submit">الاشتراك</button>
                                </form>
                                <div class="footer-social footer-social-two">
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
                                        {{-- <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                        <li><a href="#"><i class="fab fa-youtube"></i></a></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom-two">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright-text-two text-center">
                            <p>جميع حقوق النشر محفوطة © {{ date('Y') }} لدى شركة الخطوة الرائدة للتجارة و الاستثمار</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer-area-end -->