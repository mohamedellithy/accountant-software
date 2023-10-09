@extends('layouts.master')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">
           رقم الاشتراك  # {{ $application_order->id }}
        </h4>
        <!-- Basic Layout -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body order-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <h5 class="heading"> تفاصيل الاشتراك</h5>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">اسم المشترك</label>
                                        <h6 style="line-height: 1.3em;">{{ $application_order->name ?: 'غير متوفر' }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">ايميل المشترك</label>
                                        <h6 style="line-height: 1.3em;">{{ $application_order->email ?: 'غير متوفر' }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">رقم جوال المشترك</label>
                                        <h6 style="line-height: 1.3em;">{{ $application_order->phone ?: 'غير متوفر' }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">وصف الاشتراك</label>
                                        <h6 style="line-height: 2em;color: #746e6e;">{{ $application_order->subscriber_notic }}</h5>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">تاريخ الاشتراك</label>
                                        <h6 style="line-height: 1.3em;">{{ $application_order->created_at }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body order-details">
                            <div class="mb-3">
                                <h5 class="heading"> تفاصيل الزبون</h5>
                            </div>
                            @if($application_order->customer)
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">اسم الزبون</label>
                                        <h6 style="line-height: 1.3em;    color: #746e6e;">{{ $application_order->customer->name ?: '-' }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">البريد الالكترونى الزبون</label>
                                        <h6 style="line-height: 1.3em;    color: #746e6e;">{{ $application_order->customer->email ?: '-' }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">رقم تليفون الزبون</label>
                                        <h6 style="line-height: 1.3em;    color: #746e6e;">{{ $application_order->customer->full_phone ?: '-' }}</h6>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    المشترك فى الخدمة غير مسجل فى المنصة
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body order-details">
                            <div class="mb-3">
                                <h5 class="heading"> تفاصيل الخدمة </h5>
                            </div>
                            @if($application_order->service)
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <img class="img-thumbnail rounded" src="{{ upload_assets($application_order->service->image_info) }}" alt="Avatar"/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">اسم الخدمة</label>
                                        <h6 style="line-height: 1.3em;">{{ $application_order->service->name }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">وصف الخدمة</label>
                                        <h6 style="line-height: 1.6em;color: #746e6e;">{!! TrimLongText($application_order->service->description,150) !!}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">رقم تواصل الخدمة</label>
                                        <h6 style="line-height: 1.3em;">{{ $application_order->service->whatsapNumber ?: '-' }}</h6>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    الخدمة غير موجودة على المنصة
                                </div>
                            @endif
                        </div>
                    </div>
                
                    <div class="card mb-4">
                        
                    </div>
                </div>

            </div>
    </div>
    <!-- / Content -->
@endsection
