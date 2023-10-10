<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" target="_blank" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('theme_2/logo.png') }}" />
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.dashboard']) }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">الرئيسية</div>
            </a>
        </li>

        <!-- products -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.products.index','admin.products.create','admin.products.edit']) }}">
            <a href="{{ route('admin.products.index') }}" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-category'></i>
                <div data-i18n="Layouts">الأصناف</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ IsActiveOnlyIf(['admin.products.index','admin.products.edit']) }}">
                    <a href="{{ route('admin.products.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">كل الاصناف</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- stock  -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.stocks.index']) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-package'></i>
                <div data-i18n="Layouts">المخزن</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ IsActiveOnlyIf(['admin.stocks.index']) }}">
                    <a href="{{ route('admin.stocks.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">عرض</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- invoices orders  -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.orders.index','admin.orders.create','admin.orders.edit','admin.orders.show']) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-package'></i>
                <div data-i18n="Layouts">فواتير البيع</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ IsActiveOnlyIf(['admin.orders.index','admin.orders.show','admin.orders.edit']) }}">
                    <a href="{{ route('admin.orders.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">عرض</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- invoices purchasing -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.purchasing-invoices.index','admin.purchasing-invoices.create','admin.purchasing-invoices.edit','admin.purchasing-invoices.show']) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-package'></i>
                <div data-i18n="Layouts">فواتير الشراء</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ IsActiveOnlyIf(['admin.purchasing-invoices.index','admin.purchasing-invoices.show','admin.purchasing-invoices.edit']) }}">
                    <a href="{{ route('admin.purchasing-invoices.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">عرض</div>
                    </a>
                </li>
            </ul>
        </li>

        <!--customers  -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.customers.index','admin.customers.create','admin.customers.edit','admin.customers.show']) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-package'></i>
                <div data-i18n="Layouts">العملاء</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ IsActiveOnlyIf(['admin.customers.index','admin.customers.show','admin.customers.edit']) }}">
                    <a href="{{ route('admin.customers.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">عرض</div>
                    </a>
                </li>
            </ul>
        </li>

        <!--suppliers  -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.suppliers.index','admin.suppliers.create','admin.suppliers.edit','admin.suppliers.show']) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-package'></i>
                <div data-i18n="Layouts">الموردين</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ IsActiveOnlyIf(['admin.suppliers.index','admin.suppliers.show','admin.suppliers.edit']) }}">
                    <a href="{{ route('admin.suppliers.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">عرض</div>
                    </a>
                </li>
            </ul>
        </li>

         <!-- Returns -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.returns.index','admin.returns.create','admin.returns.edit','admin.returns.show']) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-package'></i>
                <div data-i18n="Layouts">المرتجعات</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ IsActiveOnlyIf(['admin.returns.index','admin.returns.show','admin.returns.edit']) }}">
                    <a href="{{ route('admin.returns.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">عرض</div>
                    </a>
                </li>
            </ul>
        </li>


        <!-- Expenses -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.expenses.index','admin.expenses.create','admin.expenses.edit','admin.expenses.show']) }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-package'></i>
                <div data-i18n="Layouts">المصروفات</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ IsActiveOnlyIf(['admin.expenses.index','admin.expenses.show','admin.expenses.edit']) }}">
                    <a href="{{ route('admin.expenses.index') }}" class="menu-link">
                        <div data-i18n="Without navbar">عرض</div>
                    </a>
                </li>
            </ul>
        </li>



    </ul>
</aside>
