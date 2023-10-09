@extends('layouts.master')

@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">عرض الخدمة</h4>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> الخدمة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages-account-settings-notifications.html"><i class="bx bx-bell me-1"></i>
                            Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages-account-settings-connections.html"><i
                                class="bx bx-link-alt me-1"></i> Connections</a>
                    </li>
                </ul>
                <div class="card mb-4">
                    <h5 class="card-header">تفاصيل الخدمة</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ upload_assets($service->image_info) }}" alt="service-avatar"
                                class="d-block rounded" height="100" width="100" id="uploadedAvatar" />

                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <h6>اسم الخدمة </h6>
                                <p>{{ $service->name }}</p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <h6>وصف الخدمة </h6>
                                <p> {{ $service->description }} </p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <h6> حالة الواتساب </h6>
                                @if ($service->whatsapStatus == 1)
                                    <span class="badge bg-label-success me-1">مفعل</span>
                                @else
                                    <span class="badge bg-label-danger me-1">معطل</span>
                                @endif
                            </div>
                            <div class="mb-3 col-md-6">
                                <h6> رقم الواتساب </h6>
                                <p> {{ $service->whatsapNumber }} </p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <h6> حالة تسجيل الدخول </h6>
                                @if ($service->loginStatus == 1)
                                    <span class="badge bg-label-success me-1">مفعل</span>
                                @else
                                    <span class="badge bg-label-danger me-1">معطل</span>
                                @endif
                            </div>
                            <div class="mb-3 col-md-6">
                                <h6> meta title </h6>
                                <p> {{ $service->meta_title }} </p>
                            </div>
                            <div class="mb-3 col-md-6">
                                <h6> meta description </h6>
                                <p> {{ $service->meta_description }} </p>
                            </div>




                        </div>


                    </div>
                    <!-- /Account -->
                </div>

            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection
