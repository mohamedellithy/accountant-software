@extends('layouts.master')
@section('content')
    <!-- Content -->
    <div class="container-fluid">

        <h4 class="fw-bold py-3 mb-4"></h4>
        <!-- Basic Layout -->

        <div class="row">

            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">بيانات العميل
                    </div>
                    <div class="card-body">

                        <div class="mb-3 d-flex">
                            <label class="form-label" for="basic-default-fullname">اسم العميل :</label>
                            <p>{{ $customers->customer->name }}</p>

                        </div>
                        <div class="mb-3 d-flex">
                            <label class="form-label" for="basic-default-fullname">رقم العميل :</label>
                            <p>{{ $customers->customer->phone }}</p>

                        </div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">طلبات العميل
                    </div>
                    @foreach ($customerOrders as $customerOrder)
                        <div class="card-body">
                            <div class="mb-3 d-flex">
                                <p>كود الطلبيه :</p>
                                <p>{{ $customerOrder->order_number }}</p>
                            </div>

                            <div class="mb-3 d-flex">
                                <p> تاريخ الطلب :</p>
                                <p>{{ $customerOrder->updated_at }}</p>

                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>المنتج</th>
                                            <th>الكمية</th>
                                            <th>السعر</th>
                                            <th>الاجمالي</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customerOrder->orderitems as $items)
                                            <tr>
                                                <td>{{ $items->product->name }}</td>
                                                <td>{{ $items->qty }}</td>
                                                <td>{{ $items->price }}</td>
                                                <td>{{ $items->qty * $items->price }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    <div class="d-flex justify-content-start">
                                        <p class="text-muted me-3">الاجمالي :</p>
                                        <span> {{ $customerOrder->total_price + $customerOrder->discount }}</span>
                                    </div>
                                    <div class="d-flex justify-content-start">
                                        <p class="text-muted me-3">التخفيض: </p>
                                        <span> {{ $customerOrder->discount }}</span>
                                    </div>
                                    <div class="d-flex justify-content-start mt-3">
                                        <h5 class="me-3">الاجمالي النهائي: </h5>
                                        <h5 class="text-success"> {{ $customerOrder->total_price }}</h5>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
    <!-- / Content -->
@endsection
