@extends('Theme_2.layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-6 col-md-4 order-1">
            <div class="row">
                <div class="col-md-12">
                    <h5>الاصناف و المخزن</h5>
                </div>
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
                                    {{ $count_products }}
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
                                    {{ $count_stocks }}
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
                <div class="col-md-12">
                    <h5>تقرير الحساب</h5>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <a href="#">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/theme_2/assets/img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
                                    </div>
                                </div>
                                <span class="d-block mb-1">اجمالي المبلغ المطلوب تحصيله</span>
                                <h3 class="card-title text-nowrap mb-2">
                                    {{ formate_price($total_must_collect) }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i> 
                                         المطلوب تحصيله
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-12 col-6 mb-4">
                    <a href="#">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/theme_2/assets/img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
                                    </div>
                                </div>
                                <span class="d-block mb-1">اجمالي المبلغ المطلوب تسديده</span>
                                <h3 class="card-title text-nowrap mb-2">
                                    {{ formate_price($total_must_paid) }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i> 
                                         المطلوب تسديده
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!--/ Total Revenue -->
        <div class="col-12 col-md-12 col-lg-12 order-3 order-md-2">
            <div class="row">
                <div class="col-md-12">
                    <h5>الفواتير</h5>
                </div>
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
                                    {{ formate_price($sales_total) }}
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
                                    {{ formate_price($purchasing_total) }}
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
                                {{ formate_price($return_total) }}
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
                                {{ formate_price($expenses_total) }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i>
                                        المصروفات
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!--/ Total Revenue -->
        <div class="col-12 col-md-12 col-lg-12 order-3 order-md-2">
            <div class="row">
                <div class="col-md-12">
                    <h5>المدفوعات</h5>
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
                                {{ formate_price($customer_payments_total) }}
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
                                    {{ formate_price($supplier_payments_total) }}
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
     <div class="row">
        <!--/ Total Revenue -->
        <div class="col-12 col-md-12 col-lg-12 order-3 order-md-2">
            <div class="row">
                <div class="col-md-12">
                    <h5>العملاء و المورديين</h5>
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
                                    {{ $customer_counts }}
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
                                    {{ $supplier_counts }}
                                </h3>
                                <small class="text-danger fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i>
                                        مورد
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
