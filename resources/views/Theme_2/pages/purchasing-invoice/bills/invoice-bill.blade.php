<html>
    <head>
    </head>
    <body>
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

                        <div class="d-flex invoice-header"style="">
                            <div class="head">
                                <strong>Green Egypt</strong><br/>
                                <strong>جرين ايجبت للمبيدات و الاسمدة</strong>
                            </div>
                            <div class="date d-flex">
                                <strong>تحرير في </strong>
                                <span>12 / 12 / 2012</span>
                            </div>
                        </div>
                        <br/>
                        <div class="d-flex custom" style="justify-content: space-between;">
                            <label>
                                <strong class="customfir" width="300px">
                                     المطلوب من السيد /
                                </strong>

                            </label>
                            <label> <strong class="customsce">فاتورة رقم  ({{ $order->order_number }}) </strong></label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap" style="">
                            <table class="table" Cellpadding="6px">
                                <thead class="table-light">
                                    <tr style="background-color:#eee;padding:15px">
                                        <th height="15"></th>
                                        <th height="15">البيان</th>
                                        <th height="15">الكمية</th>
                                        <th height="15">السعر</th>
                                        <th height="15">الاجمالى</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->invoice_items as $item)
                                        <tr>
                                            <td height="25">{{ $loop->iteration }}</td>
                                            <td height="25">{{ $item->product->name }}</td>

                                            <td height="25">{{ $item->qty }}</td>
                                            <td height="25">{{ formate_price($item->price) }}</td>
                                            <td height="25">{{ formate_price($item->price * $item->qty)  }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td height="35"></td>
                                        <td height="35">
                                            اجمالى القيمة النهائية
                                        </td>
                                        <td colspan="4" height="35" style="text-align: left;padding-left: 56px;">{{ formate_price($order->total_price) }}</td>
                                    </tr>
                                    <tr>
                                        <td height="35"></td>
                                        <td height="35">
                                            اجمالى القيمة المدفوع
                                        </td>
                                        <td colspan="4" height="35" style="text-align: left;padding-left: 56px;">{{ formate_price($order->invoice_payments()->sum('value')) }}</td>
                                    </tr>
                                    <tr>
                                        <td height="35"></td>
                                        <td height="35">
                                            اجمالى الباقي من الفاتورة
                                        </td>
                                        <td colspan="4" height="35" style="text-align: left;padding-left: 56px;">{{ formate_price($order->total_price - $order->invoice_payments()->sum('value')) }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            مبالغ سابقة
                                        </td>
                                        <td colspan="4" style="text-align: left;padding-left: 56px;">{{ formate_price(abs(get_balance_stake_holder($order->supplier)) - ($order->total_price - $order->invoice_payments()->sum('value')) ) }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            اجمالى الباقي
                                        </td>
                                        <td colspan="4" style="text-align: left;padding-left: 56px;">{{ formate_price(get_balance_stake_holder($order->supplier)) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex footer" style="justify-content: space-between;padding-top: 15px;">
                            <label style="width:300px">
                                <strong>
                                    المستلم /
                                </strong>

                            </label>
                            <label>
                                <strong class="signature">
                                    التوقيع /
                                </strong>
                                ............................................................
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>