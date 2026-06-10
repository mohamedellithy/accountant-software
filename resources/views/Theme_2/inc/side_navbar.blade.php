<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" target="_blank" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('logo.png') }}" />
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

        <!-- Products -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.products.index','admin.products.show','admin.products.create','admin.products.edit']) }}">
            <a href="{{ route('admin.products.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div>الاصناف</div>
            </a>
        </li>

        <!-- Stock -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.stocks.index']) }}">
            <a href="{{ route('admin.stocks.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store-alt"></i>
                <div>المخزن</div>
            </a>
        </li>

        <!-- Sale Invoices -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.orders.index','admin.orders.create','admin.orders.edit','admin.orders.show']) }}">
            <a href="{{ route('admin.orders.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div>فواتير البيع</div>
            </a>
        </li>

        <!-- Purchasing Invoices -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.purchasing-invoices.index','admin.purchasing-invoices.create','admin.purchasing-invoices.edit','admin.purchasing-invoices.show']) }}">
            <a href="{{ route('admin.purchasing-invoices.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cart"></i>
                <div>فواتير الشراء</div>
            </a>
        </li>

        <!-- Customers -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.customers.index','admin.customers.create','admin.customers.edit','admin.customers.show']) }}">
            <a href="{{ route('admin.customers.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div>العملاء</div>
            </a>
        </li>

        <!-- المطلوب تحصيله (عملاء) -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.customers.debts']) }}">
            <a href="{{ route('admin.customers.debts') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div>المطلوب تحصيله (عملاء)</div>
            </a>
        </li>

        <!-- Suppliers -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.suppliers.index','admin.suppliers.create','admin.suppliers.edit','admin.suppliers.show']) }}">
            <a href="{{ route('admin.suppliers.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-truck"></i>
                <div>الموردين</div>
            </a>
        </li>

        <!-- المطلوب تسديده (موردين) -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.suppliers.debts']) }}">
            <a href="{{ route('admin.suppliers.debts') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-credit-card"></i>
                <div>المطلوب تسديده (موردين)</div>
            </a>
        </li>

        <!-- Returns -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.returns.index','admin.returns.create','admin.returns.edit','admin.returns.show']) }}">
            <a href="{{ route('admin.returns.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-undo"></i>
                <div>المرتجعات</div>
            </a>
        </li>

        <!-- Expenses -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.expenses.index','admin.expenses.create','admin.expenses.edit','admin.expenses.show']) }}">
            <a href="{{ route('admin.expenses.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-money-withdraw"></i>
                <div>المصروفات</div>
            </a>
        </li>

        <!-- Customers Payments -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.payments.customers-index']) }}">
            <a href="{{ route('admin.payments.customers-index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-wallet"></i>
                <div>مدفوعات العملاء</div>
            </a>
        </li>

        <!-- Suppliers Payments -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.payments.suppliers-index']) }}">
            <a href="{{ route('admin.payments.suppliers-index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-wallet"></i>
                <div>مدفوعات الموردين</div>
            </a>
        </li>

        <!-- Settings -->
        <li class="menu-item {{ IsActiveOnlyIf(['admin.settings.index']) }}">
            <a href="{{ route('admin.settings.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Analytics">إعدادات الفاتورة</div>
            </a>
        </li>
    </ul>
</aside>
