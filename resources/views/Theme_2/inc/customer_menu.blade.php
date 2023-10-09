<ul>
    <li class="{{ IsActiveOnlyIf(['my-account']) }}">
        <a href="{{ route('my-account') }}">
            <i class="fas fa-tachometer-alt"></i> الرئيسية
        </a>
    </li>
    <li class="{{ IsActiveOnlyIf(['my-orders']) }}">
        <a href="{{ route('my-orders') }}">
            <i class="fas fa-shopping-bag"></i> الطلبات
        </a>
    </li>
    <li class="{{ IsActiveOnlyIf(['my-services']) }}">
        <a href="{{ route('my-services') }}">
            <i class="fas fa-th-list"></i> الخدمات
        </a>
    </li>
    <li class="{{ IsActiveOnlyIf(['my-downloads','single_download']) }}">
        <a href="{{ route('my-downloads') }}">
            <i class="fas fa-th-list"></i> التحميلات
        </a>
    </li>
    <li class="{{ IsActiveOnlyIf(['setting-account']) }}">
        <a href="{{ route('setting-account') }}">
            <i class="fas fa-user-cog"></i> اعدادات الحساب
        </a>
    </li>
    <li>
        <a href="#" onclick="document.getElementById('logout_account').submit()">
            <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
        </a>
        <form id="logout_account" method="post" action="{{ route('logout') }}">
            @csrf
        </form>
    </li>
</ul>