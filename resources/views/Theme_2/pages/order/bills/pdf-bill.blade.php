<!DOCTYPE html>
<html lang="ar" class="light-style layout-menu-fixed" dir="rtl">

<head>
    <meta name="google-site-verification" content="40aCnX7tt4Ig1xeLHMATAESAkTL2pn15srB14sB-EOs" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
</head>
<body>
        <div class="row">
            <div class="col-lg-8">
                 <!-- Basic Card Example -->
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <div class="d-flex invoice-header">
                            <div class="head">
                                <strong>Green Egypt</strong><br/>
                                <strong>جرين ايجبت للمبيدات و الاسمدة</strong>
                            </div>
                            <div class="date d-flex">
                                <strong>تحرير في </strong>
                                <span>{{ date('Y-m-d') }}</span>
                            </div>
                        </div>
                        <div class="d-flex custom" style="width:100%;justify-content: space-between;">
                            <label width="300px" style="margin-right:0px !important">
                                <strong class="customfir">
                                     المطلوب من السيد /
                                </strong>
                                {{ $order->customer->name }}
                            </label>
                            <label style="margin-left:0px !important">
                                <strong class="customsce">
                                    فاتورة رقم  ({{ $order->order_number }})
                                </strong>
                            </label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table" Cellpadding="6px">
                                <thead class="table-light">
                                    <tr height="25" style="background-color:#eee;">
                                        <th height="15" style="padding:35px !important"></th>
                                        <th height="15" style="padding:35px !important">البيان</th>
                                        <th height="15" style="padding:35px !important">الوحدة</th>
                                        <th height="15" style="padding:35px !important">الكمية</th>
                                        <th height="15" style="padding:35px !important">السعر</th>
                                        <th height="15" style="padding:35px !important">الاجمالى</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $order_item)
                                        <tr style="padding:35px">
                                            <td height="25" align="center">{{ $loop->iteration }}</td>
                                            <td height="25" align="center">{{ $order_item->product->name }}</td>
                                            <td height="25" align="center"></td>
                                            <td height="25" align="center">{{ $order_item->qty }}</td>
                                            <td height="25" align="center">{{ formate_price($order_item->price) }}</td>
                                            <td height="25" align="center">{{ formate_price($order_item->price * $order_item->qty)  }}</td>
                                        </tr>
                                    @endforeach
                                    <tr height="35">
                                        <td></td>
                                        <td height="35" align="center">
                                            اجمالى البيان فقط قدرة
                                        </td>
                                        <td colspan="4" height="35" align="center">{{ formate_price($order->sub_total) }}</td>
                                    </tr>
                                    <tr height="45">
                                        <td></td>
                                        <td height="35" align="center">
                                            الخصم المطبق
                                        </td>
                                        <td colspan="4" height="35" align="center">{{ formate_price($order->discount) }}</td>
                                    </tr>
                                    <tr height="45">
                                        <td></td>
                                        <td height="35" align="center">
                                            اجمالى القيمة النهائية
                                        </td>
                                        <td colspan="4" height="35" align="center">{{ formate_price($order->total_price) }}</td>
                                    </tr>
                                    <tr height="35">
                                        <td></td>
                                        <td height="35" align="center">
                                            مدفوع نقدا
                                        </td>
                                        <td colspan="4" height="35" align="center">{{ formate_price($order->order_payments_sum_value) }}</td>
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
        </div>
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

 </style>
 </body>
 <html>
