@extends('Theme_2.layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-6 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">مرحيا {{ auth()->user()->name }} 🎉</h5>
                            <p class="mb-4">
                                يمكنك التحكم فى كل تفاصيل المنصة و متابعة نشاطات المنصة
                            </p>

                            <a  class="btn btn-sm btn-outline-primary">
                                ابدأ الان
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="/theme_2/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <a href="{{ route('admin.products.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="/theme_2/assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">
                                    الاصناف
                                </span>
                                <h3 class="card-title mb-2">
                                    {{ App\Models\Product::count() }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i>
                                        صنف
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <a href="{{ route('admin.stocks.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="/theme_2/assets/img/icons/unicons/chart.png" alt="Credit Card" class="rounded" />
                                    </div>
                                </div>
                                <span>المخزن</span>
                                <h3 class="card-title text-nowrap mb-1">
                                    {{ App\Models\Stock::count() }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i>
                                        صنف
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
    </div>
    <div class="row">
        <!--/ Total Revenue -->
        <div class="col-12 col-md-12 col-lg-12 order-3 order-md-2">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <a href="{{ route('admin.orders.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/theme_2/assets/img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
                                    </div>
                                </div>
                                <span class="d-block mb-1">فواتير البيع</span>
                                <h3 class="card-title text-nowrap mb-2">
                                    {{ formate_price(App\Models\Order::sum('total_price')) }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i> 
                                        اجمالى المبيعات
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <a href="{{ route('admin.purchasing-invoices.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/theme_2/assets/img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
                                    </div>
                                </div>
                                <span class="d-block mb-1">فواتير الشراء</span>
                                <h3 class="card-title text-nowrap mb-2">
                                    {{ formate_price(App\Models\PurchasingInvoice::sum('total_price')) }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i> 
                                        اجمالى فواتير الشراء
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <a href="{{ route('admin.customers.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/theme_2/assets/img/icons/unicons/cc-primary.png') }}" alt="Credit Card" class="rounded" />
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">العملاء</span>
                                <h3 class="card-title mb-2">
                                    {{ \App\Models\StakeHolder::customer()->count() }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i>
                                        عميل
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <a href="{{ route('admin.suppliers.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/theme_2/assets/img/avatars/user_avatar.png') }}" alt="Credit Card" class="rounded" />
                                    </div>
                                </div>
                                <span>الموردين</span>
                                <h3 class="card-title text-nowrap mb-1">
                                    {{ \App\Models\StakeHolder::supplier()->count() }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i>
                                        مورد
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <a href="#s">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/theme_2/assets/img/icons/unicons/chart.png') }}" alt="Credit Card" class="rounded" />
                                    </div>
                                </div>
                                <span>المرتجعات</span>
                                <h3 class="card-title text-nowrap mb-1">
                                {{ formate_price(\App\Models\ReturnItem::sum(\DB::raw('return_items.quantity * return_items.price'))) }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i>
                                        اجمالى المرتجع
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <a href="#s">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/theme_2/assets/img/icons/unicons/chart.png') }}" alt="Credit Card" class="rounded" />
                                    </div>
                                </div>
                                <span>المصروفات</span>
                                <h3 class="card-title text-nowrap mb-1">
                                {{ formate_price(\App\Models\Expense::sum('price')) }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i>
                                        المصروفات
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <a href="#s">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/theme_2/assets/img/icons/unicons/chart.png') }}" alt="Credit Card" class="rounded" />
                                    </div>
                                </div>
                                <span>مدفوعات العملاء</span>
                                <h3 class="card-title text-nowrap mb-1">
                                {{ formate_price(\App\Models\CustomerPayment::sum('value')) }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i>
                                    مدفوعات العملاء
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <a href="#s">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/theme_2/assets/img/icons/unicons/chart.png') }}" alt="Credit Card" class="rounded" />
                                    </div>
                                </div>
                                <span>مدفوعات الموردين</span>
                                <h3 class="card-title text-nowrap mb-1">
                                    {{ formate_price(\App\Models\SupplierPayment::sum('value')) }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i>
                                    مدفوعات الموردين
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
