@extends('layouts.master')

@section('content')
    <div class="container-fluid" id="print">
        <div class="container mt-5">
            <div class="d-flex justify-content-center row">
                <div class="col-md-8">
                    <div class="p-3 bg-white rounded">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-uppercase">تفاصيل الطلبية</h5>
                                {{-- <div class="billed"><span class="font-weight-bold text-uppercase">Billed:</span><span
                                        class="ml-1">Jasper Kendrick</span></div> --}}
                                <div class="billed p-2"><span class="font-weight-bold text-uppercase">التاريخ: </span><span
                                        class="ml-1">{{ $order->created_at }}</span></div>
                                <div class="billed p-2"><span class="font-weight-bold text-uppercase">كود الطلب:</span><span
                                        class="ml-1">{{ $order->order_number }}</span></div>
                                <div class="billed p-2"><span class="font-weight-bold text-uppercase">حالة
                                        الطلب:</span><span class="ml-1">{{ $order->order_status }}</span></div>
                            </div>
                            <div class="col-md-6 text-left mt-3">
                                <div class="billed p-2"><span class="font-weight-bold text-uppercase">اسم الزبون:
                                    </span><span class="ml-1"> {{ $order->customer->name }}</span></div>
                                <div class="billed p-2"><span class="font-weight-bold text-uppercase"> رقم الجوال:
                                    </span><span class="ml-1"> {{ $order->customer->phone }}</span></div>
                            </div>
                        </div>
                        <div class="mt-3">
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
                                        @foreach ($order->orderitems as $items)
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
                                        <span> {{ $order->total_price + $order->discount }}</span>
                                    </div>
                                    <div class="d-flex justify-content-start">
                                        <p class="text-muted me-3">التخفيض: </p>
                                        <span> {{ $order->discount }}</span>
                                    </div>
                                    <div class="d-flex justify-content-start mt-3">
                                        <h5 class="me-3">اجمالي النهائي: </h5>
                                        <h5 class="text-success"> {{ $order->total_price }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-10">
                                <form action="{{ route('orders.update', $order->id) }}" method="post">
                                    @method('PUT')
                                    @csrf

                                    <div class=" d-flex">
                                        <div class="form-group mx-1">
                                            <select name="order_status" class="form-control ">
                                                <option value="pending">Pending</option>
                                                <option value="not_completed">Not Completed</option>
                                                <option value="cancelled">Cancelled</option>
                                                <option value="completed">Complete</option>
                                            </select>

                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary ">تعديل الطلب</button>
                                        </div>


                                    </div>

                                </form>
                            </div>
                            <div class="col-md-2">
                                <a class="text-decoration-none " href="javascript:void(0);"
                                    onclick="printPageArea('print')"><i class="fas fa-print text-black"></i>طباعة</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
<script>
    function printPageArea(print) {
        var printContent = document.getElementById(print).innerHTML;
        var originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
    }
</script>
