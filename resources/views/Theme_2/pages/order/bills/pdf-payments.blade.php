<!DOCTYPE html>
<html lang="ar" class="light-style layout-menu-fixed" dir="rtl">
    <head>
        <meta name="google-site-verification" content="40aCnX7tt4Ig1xeLHMATAESAkTL2pn15srB14sB-EOs" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    </head>
    <body>
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
                        <th height="25" style="color:black !important">الدفعة</th>
                        <th height="25" style="color:black !important">تاريخ الدفعة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->order_payments as $payment)
                        <tr>
                            <td height="25" style="color:black !important">{{ formate_price($payment->value) }}</td>
                            <td height="25" style="color:black !important">{{ $payment->created_at }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td height="25" style="color:black !important">سعر الطلبية</td>
                        <td height="25" style="color:black !important">{{ formate_price($order->total_price) }}</td>
                    </tr>
                    <tr>
                        <td height="25" style="color:black !important">المدفوع</td>
                        <td height="25" style="color:black !important" >{{ formate_price($order->order_payments_sum_value) }}</td>
                    </tr>
                    <tr>
                        <td height="25" style="color:black !important">المتبقي</td>
                        <td height="25" style="color:black !important">{{ formate_price($order->total_price - $order->order_payments_sum_value) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>