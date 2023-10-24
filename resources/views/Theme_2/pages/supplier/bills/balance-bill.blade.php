<html>
    <head>
        <meta name="google-site-verification" content="40aCnX7tt4Ig1xeLHMATAESAkTL2pn15srB14sB-EOs" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />    
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">
                        كشف حساب {{ $customer->name }}
                    </h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-border">
                            <thead class="table-light">
                                <tr class="table-dark" style="background-color:#eee;padding:10px" height="25">
                                    <th height="20">رقم الفاتورة</th>
                                    <th height="20">تاريخ الفاتورة</th>
                                    <th height="20">العملية</th>
                                    <th height="20">البيان</th>
                                    <th height="20">الكمية</th>
                                    <th height="20">السعر</th>
                                    <th height="20">مدين</th>
                                    <th height="20">دائن</th>
                                    <th height="20">الرصيد</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <?php $balance = 0; ?>
                                <?php $credit = 0; ?>
                                <?php $debit = 0; ?>
                                @foreach ($orders as $order)
                                    @if(isset($order->order_id))
                                        @php $balance  = $balance - ($order->qty * $order->price)  @endphp
                                        @php $credit  += $order->qty * $order->price @endphp
                                        <tr style="border:1px solid gray;" height="25">
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                <strong>
                                                    {{ $order->order_id }}#
                                                </strong>
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                <span class="badge bg-label-primary me-1">
                                                    {{ date('Y-m-d',strtotime($order->created_at)) }}
                                                </span>
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                مبيعات
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ isset($order->product_name) ? $order->product_name : '-' }} 
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ isset($order->qty) ? $order->qty : '-' }} 
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ isset($order->price) ? formate_price($order->price) : '-' }} 
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ isset($order->qty) ? formate_price($order->qty * $order->price) : '-' }} 
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                -
                                            </td>
                                            <td style="direction: ltr;" style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ formate_price($balance) }} 
                                            </td>
                                        </tr>
                                    @elseif(isset($order->purchasing_invoices_id))
                                        @php $balance = $balance + ($order->qty * $order->price)  @endphp
                                        @php $debit  += $order->qty * $order->price @endphp
                                        <tr style="border:1px solid gray;" height="25">
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                <strong>
                                                    {{ $order->purchasing_invoices_id }}#
                                                </strong>
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                <span class="badge bg-label-primary me-1">
                                                    {{ date('Y-m-d',strtotime($order->created_at)) }}
                                                    
                                                </span>
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                مشتريات
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ isset($order->product_name) ? $order->product_name : '-' }} 
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ isset($order->qty) ? $order->qty : '-' }} 
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ isset($order->price) ? formate_price($order->price) : '-' }} 
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                - 
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ isset($order->qty) ? formate_price($order->qty * $order->price) : '-' }}
                                            </td>
                                            <td style="direction: ltr;" style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ formate_price($balance) }} 
                                            </td>
                                        </tr>
                                    @elseif(isset($order->customer_payments_id))
                                        @php $balance = $balance + $order->payment_values  @endphp
                                        @php $debit  += $order->payment_values @endphp
                                        <tr style="border:1px solid gray;" height="25">
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                <strong>
                                                    -
                                                </strong>
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                <span class="badge bg-label-primary me-1">
                                                    {{ date('Y-m-d',strtotime($order->created_at)) }}
                                                </span>
                                            </td>
                                            <td colspan="5" style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                تم تحصيل كاش من العميل
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ formate_price($order->payment_values) }} 
                                            </td>
                                            <td style="direction: ltr;" style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ formate_price($balance) }} 
                                            </td>
                                        </tr>
                                    @elseif(isset($order->supplier_payments_id))
                                        @php $balance = $balance - $order->payment_values  @endphp
                                        @php $credit  += $order->payment_values @endphp
                                        <tr style="border:1px solid gray;" height="25">
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                <strong>
                                                    -
                                                </strong>
                                            </td>
                                            <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                <span class="badge bg-label-primary me-1">
                                                    {{ date('Y-m-d',strtotime($order->created_at)) }}
                                                </span>
                                            </td>
                                            <td colspan="4" style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                تم دفع كاش للعميل 
                                            </td>
                                            <td colspan="2" style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ formate_price($order->payment_values) }} 
                                            </td>
                                            <td style="direction: ltr;" style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                                {{ formate_price($balance) }} 
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr style="background-color: #E8F5E9;border:4px solid #171615;">
                                    <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                        {{ date('Y-m-d') }}
                                    </td>
                                    <td colspan="5" style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                        الرصيد الختامى
                                    </td>
                                    <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                        {{ formate_price($credit) }}
                                    </td>
                                    <td style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                        {{ formate_price($debit) }}
                                    </td>
                                    <td style="direction: ltr;" style="border-bottom:1px solid #171615;border-left:1px solid #171615;">
                                        {{ formate_price($balance) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .table{
                with:100%;
                text-align: right !important;
                border-bottom:1px solid gray !important;
            }
            .table tr td,
            .table th td {
                text-align: right !important;
            }
            .table tr td
            {
                margin:0px;
                border:1px solid gray !important;
            }
        </style>
</body>
</html>