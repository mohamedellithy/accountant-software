@extends('layouts.master')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">
           طلبية رقم  # {{ $order->order_no }}
        </h4>
        <!-- Basic Layout -->
            <form action="{{ route('admin.orders.update',$order->order_no) }}" method="post">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="form-status-change" style="">
                        <div class="form-group">
                            <select name="order_status" class="form-control" style="height: 50px;">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="on-hold">on-hold</option>
                                <option value="cancelled">cancelled</option>
                                <option value="completed">Complete</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">تعديل المنتج</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body order-details">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h5 class="heading"> الطلبية</h5>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">كود الطلبية</label>
                                        <h6 style="line-height: 1.3em;">{{ $order->order_no }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">حالة الطلبية</label>
                                        <h6 style="line-height: 1.3em;">{{ $order->order_status }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">اجمالى سعر الطلبية</label>
                                        <h6 style="line-height: 1.3em;">{{ formate_price($order->order_total) }}</h5>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">تاريخ الطلبية</label>
                                        <h6 style="line-height: 1.3em;">{{ $order->created_at }}</h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="mb-3">
                                            <h5 class="heading">تفاصيل الطلبية</h5>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-fullname">المنتج</label>
                                            <h6 style="line-height: 1.3em;">{{ $order->order_items ? $order->order_items->product->name : '-' }}</h6>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-fullname">الكمية</label>
                                            <h6 style="line-height: 1.3em;">{{ $order->order_items ? $order->order_items->quantity : '-' }} قطعة</h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3">
                                            <h5 class="heading">تفاصيل المدفوعات</h5>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-fullname">اسم الزبون</label>
                                            <h6 style="line-height: 1.3em;">{{ $order->customer->name }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body order-details">
                            <div class="mb-3">
                                <h5 class="heading"> تفاصيل الزبون</h5>
                            </div>
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">اسم الزبون</label>
                                    <h6 style="line-height: 1.3em;">{{ $order->customer->name }}</h6>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">البريد الالكترونى الزبون</label>
                                    <h6 style="line-height: 1.3em;">{{ $order->customer->email }}</h6>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">رقم تليفون الزبون</label>
                                    <h6 style="line-height: 1.3em;">{{ $order->customer->full_phone ?: '-' }}</h6>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">دولة </label>
                                    <h6 style="line-height: 1.3em;">{{ $order->customer->phone_code ? CountriesPhonesCode($order->customer->phone_code) : '-' }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- / Content -->
@endsection
