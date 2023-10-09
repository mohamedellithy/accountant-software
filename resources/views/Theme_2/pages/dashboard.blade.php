@extends('Theme_2.layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
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
        <div class="col-lg-4 col-md-4 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="/theme_2/assets/img/icons/unicons/chart-success.png" alt="chart success" class="rounded" />
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">
                                منتجات
                            </span>
                            <h3 class="card-title mb-2">
                                963258741
                            </h3>
                            <small class="text-success fw-semibold"><i
                                    class="bx bx-up-arrow-alt"></i>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="/theme_2/assets/img/icons/unicons/chart.png" alt="Credit Card" class="rounded" />
                                </div>
                            </div>
                            <span>خدمات</span>
                            <h3 class="card-title text-nowrap mb-1">
                                98521478
                            </h3>
                            <small class="text-success fw-semibold"><i
                                    class="bx bx-up-arrow-alt"></i></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Revenue -->
    </div>
    <div class="row">
        <!-- Order Statistics -->
        <div class="col-md-6 col-lg-8 col-xl-8 order-0 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">أخر الطلبات</h5>
                    </div>
                    <div class="dropdown">
                        <a  class="btn p-0" type="button" id="orederStatistics">
                            <i class="bx bx-dots-vertical-rounded"></i>
                            عرض الكل
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2">
                                985632587
                            </h2>
                            <span>اجمالى الطلبات</span>
                        </div>
                        {{-- <div id="orderStatisticsChart"></div> --}}
                    </div>
                    <ul class="p-0 m-0">
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Order Statistics -->
        <!--/ Total Revenue -->
        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
            <div class="row">
                <div class="col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('/theme_2/assets/img/icons/unicons/paypal.png') }}" alt="Credit Card" class="rounded" />
                                </div>
                            </div>
                            <span class="d-block mb-1">الطلبات</span>
                            <h3 class="card-title text-nowrap mb-2">
                                9874532
                            </h3>
                            <small class="text-danger fw-semibold"><i
                                    class="bx bx-down-arrow-alt"></i> </small>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('/theme_2/assets/img/icons/unicons/cc-primary.png') }}" alt="Credit Card" class="rounded" />
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">المدفوعات</span>
                            <h3 class="card-title mb-2">
                                {{ formate_price('98746522') }}
                            </h3>
                            <small class="text-success fw-semibold"><i
                                    class="bx bx-up-arrow-alt"></i> </small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('/theme_2/assets/img/avatars/user_avatar.png') }}" alt="Credit Card" class="rounded" />
                                </div>
                            </div>
                            <span>المستخدمين</span>
                            <h3 class="card-title text-nowrap mb-1">
                                98745632
                            </h3>
                            <small class="text-success fw-semibold"><i
                                    class="bx bx-up-arrow-alt"></i></small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('/theme_2/assets/img/icons/unicons/chart.png') }}" alt="Credit Card" class="rounded" />
                                </div>
                            </div>
                            <span>طلبات التسعير</span>
                            <h3 class="card-title text-nowrap mb-1">
                               8751
                            </h3>
                            <small class="text-success fw-semibold"><i
                                    class="bx bx-up-arrow-alt"></i></small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">أخر طلبات التسعير</h5>
                            <a class="btn p-0" type="button">
                                <i class="bx bx-dots-vertical-rounded"></i>
                                عرض الكل
                            </a>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 m-0">

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
