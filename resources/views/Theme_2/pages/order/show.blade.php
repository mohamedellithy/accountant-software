 <!-- Begin Page Content -->
 @extends('Theme_2.layouts.master')

 @section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{ $order->order_no }}</h1>
        </div>
        <div class="row">
            <div class="col-lg-8">
                 <!-- Basic Card Example -->
                <div class="card mb-4" id="DivIdToPrint">
                    <style>
                        @media print {
                            #DivIdToPrint{
                                width: 551px !important;
                                border: 2px solid red !important;
                            }
                            table{
                                border:1px solid;
                                width:100%;
                                margin-top:10px
                            }
                            .table-light th{
                                color: #566a7f !important;
                                border-left: 1px solid;
                            }
                            .table tr{
                                border : 1px solid gray
                            }
                            .table td{
                                border: 1px solid #cac7c7;
                                text-align: center;
                            }
                            .invoice-header{
                                flex-direction: row !important;
                                justify-content: space-between !important;
                                align-items: center !important;
                            }

                            .invoice-header .date{
                                margin-right:600px !important;
                            }
                            .invoice-header .date span{
                                padding: 10px;
                            }
                            .footer .signature{
                                margin-right:410px !important;
                            }
                            .custom .customsce{
                                margin-right:510px !important;
                            }
                        }
                    </style>
                    <div class="card-header py-3">
                        <div class="d-flex invoice-header">
                            <div class="head">
                                <strong>{{ env('logo_pdf_title') }}</strong>
                            </div>
                            <div class="date d-flex">
                                <strong>تحرير في </strong>
                                <span>{{ date('Y-m-d') }}</span>
                            </div>
                        </div>
                        <br/>
                        <div class="d-flex custom" style="justify-content: space-between;">
                            <label>
                                <strong class="customfir">
                                     المطلوب من السيد /
                                </strong>
                                {{ $order->customer->name }}
                            </label>
                            <label>
                                <strong class="customsce">
                                    فاتورة رقم  ({{ $order->order_number }})
                                </strong>
                            </label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        <th>البيان</th>
                                        <th>الوحدة</th>
                                        <th>الكمية</th>
                                        <th>السعر</th>
                                        <th>الاجمالى</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sub_total = 0 @endphp
                                    @foreach($order->orderItems as $order_item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $order_item->product->name }}</td>
                                            <td></td>
                                            <td>{{ $order_item->qty }}</td>
                                            <td>{{ formate_price($order_item->price) }}</td>
                                            <td>{{ formate_price($order_item->price * $order_item->qty)  }}</td>
                                        </tr>
                                        @php $sub_total += $order_item->price * $order_item->qty @endphp
                                    @endforeach
                                    <tr style="border-top:2px solid black">
                                        <td></td>
                                        <td>
                                            اجمالى البيان فقط قدرة
                                        </td>
                                        <td colspan="4" style="text-align: left;padding-left: 56px;">{{ formate_price($sub_total) }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            الخصم المطبق
                                        </td>
                                        <td colspan="4" style="text-align: left;padding-left: 56px;">{{ formate_price($order->discount) }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            اجمالى القيمة النهائية
                                        </td>
                                        <td colspan="4" style="text-align: left;padding-left: 56px;">{{ formate_price($order->total_price) }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            مدفوع نقدا
                                        </td>
                                        <td colspan="4" style="text-align: left;padding-left: 56px;">{{ formate_price($order->order_payments_sum_value) }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            الباقي من ثمن الفاتورة
                                        </td>
                                        <td colspan="4" style="text-align: left;padding-left: 56px;">
                                            {{ formate_price(($order->total_price - $order->order_payments_sum_value)) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            مبالغ سابقة
                                        </td>
                                        <td colspan="4" style="text-align: left;padding-left: 56px;">{{ formate_price(abs(get_balance_stake_holder($order->customer)) - ($order->total_price - $order->order_payments_sum_value)) }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            اجمالى الباقي
                                        </td>
                                        <td colspan="4" style="text-align: left;padding-left: 56px;">
                                            {{ formate_price(get_balance_stake_holder($order->customer)) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex footer" style="justify-content: space-between;padding-top: 15px;">
                            <label>
                                <strong>
                                    المستلم /
                                </strong>
                                {{ $order->customer->name }}
                            </label>
                            <label>
                                <strong class="signature">
                                    التوقيع /
                                </strong>
                                .............
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Basic Card Example -->
                <div class="card mb-4">
                   <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <p>فاتورة رقم</p>
                            <p class="text-dark" style="padding: 13px;background-color:#eee">{{ $order->order_number }}</p>
                        </h6>
                        <h6 class="m-0 font-weight-bold text-primary">
                            <p>اسم العميل</p>
                            <p class="text-dark" style="padding: 13px;background-color:#eee">{{ $order->customer->name }}</p>
                        </h6>
                        <h6 class="m-0 font-weight-bold text-primary">
                            <p>رقم هاتف العميل</p>
                            <p class="text-dark" style="padding: 13px;background-color:#eee">{{ $order->customer->phone }}</p>
                        </h6>
                   </div>
                   <div class="card-body">
                        <a href="{{ route('admin.orders.edit',$order->id) }}" class="btn btn-danger btn-sm">تعديل الفاتورة</a><br/><br/>
                        <button class="btn btn-primary btn-sm" onclick="printDiv('DivIdToPrint');">طباعة الفاتورة</button>
                        <a href="{{ route('admin.download-pdf-order-bill',['id' => $order->id]) }}" class="btn btn-success btn-sm">تنزيل الفاتورة</a>
                   </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <button style="float:left" class="btn btn-primary btn-sm" onclick="printDiv('paymentsOrder');">طباعة المدفوعات</button>
                        <a href="{{ route('admin.download-pdf-payments-bill',['id' => $order->id]) }}" class="btn btn-success btn-sm">تنزيل المدفوعات</a>
                    </div>
                    <div class="card-body" id="paymentsOrder">
                        <style>
                            @media print{
                                .table-payments{
                                    with:100%;
                                    text-align: right !important;
                                    border:1px solid gray !important;
                                }
                                .table-payments tr td,
                                .table-payments th td {
                                    text-align: right !important;
                                }
                                .table-payments tr td
                                {
                                    margin:0px;
                                    border:1px solid gray !important;
                                }
                            }
                        </style>
                        <h5>تواريخ الدفعات</h5>
                        <p>دفعات السيد / {{ $order->customer->name }}</p>
                        <p>رقم الطلبية / {{ $order->order_number }}</p>
                        <table class="table table-border table-payments" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="background-color:#eee;color:black !important">الدفعة</th>
                                    <th style="background-color:#eee;color:black !important">تاريخ الدفعة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->order_payments as $payment)
                                    <tr>
                                        <td style="color:black !important">{{ formate_price($payment->value) }}</td>
                                        <td style="color:black !important">{{ $payment->created_at }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="background-color:rgb(236, 236, 236);color:black !important">سعر الطلبية</td>
                                    <td style="background-color:rgb(236, 236, 236);color:black !important">{{ formate_price($order->total_price) }}</td>
                                </tr>
                                <tr>
                                    <td style="background-color:rgb(236, 236, 236);color:black !important">المدفوع</td>
                                    <td style="background-color:rgb(236, 236, 236);color:black !important" >{{ formate_price($order->order_payments_sum_value) }}</td>
                                </tr>
                                <tr>
                                    <td style="background-color:rgb(236, 236, 236);color:black !important">المتبقي</td>
                                    <td style="background-color:rgb(236, 236, 236);color:black !important">{{ formate_price($order->total_price - $order->order_payments_sum_value) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                 </div>
           </div>
        </div>
    </div>
    <!-- /.container-fluid -->
 @endsection


 @push('style')
 <style>
     .table-light th{
        color: #566a7f !important;
        border-left: 1px solid lightgray;
    }
    .table tr{
        border : 1px solid gray
    }
    .table td{
        border: 1px solid #cac7c7;
        /* text-align: left; */
    }
    .invoice-header{
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
    .invoice-header .date{
        align-items: center;
    }
    .invoice-header .date span{
        padding: 10px;
    }

    @media(max-width:1000px){
        .table:not(.table-dark) tr th:first-child, 
        .table:not(.table-dark) tr th:nth-child(2){
            background-color:white !important;
        }
        .invoice-header .head{
            font-size: 10px;
        }
        .invoice-header .date{
            font-size: 8px;
        }
        .card-header .custom{
            font-size: 11px;
        }
    }

 </style>
 @endpush
