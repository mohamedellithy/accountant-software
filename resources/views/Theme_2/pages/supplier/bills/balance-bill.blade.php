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
                                <tr class="table-dark" style="background-color:#eee;padding:10px;border:1px solid black" height="25">
                                    <th height="20" style="border:1px solid black">رقم الفاتورة</th>
                                    <th height="20" style="border:1px solid black">تاريخ الفاتورة</th>
                                    <th height="20" style="border:1px solid black">العملية</th>
                                    <th height="20" style="border:1px solid black">البيان</th>
                                    <th height="20" style="border:1px solid black">الكمية</th>
                                    <th height="20" style="border:1px solid black">السعر</th>
                                    <th height="20" style="border:1px solid black">مدين</th>
                                    <th height="20" style="border:1px solid black">دائن</th>
                                    <th height="20" style="border:1px solid black">الرصيد</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <?php $balance = $supplier->balance ?: 0; ?>
                                <?php $credit = 0; ?>
                                <?php $debit = 0; ?>
                                <tr style="border:1px solid black">
                                    <td style="border:1px solid black"></td>
                                    <td style="border:1px solid black">
                                        {{ date('Y-m-d') }}
                                    </td>
                                    <td colspan="5" style="border:1px solid black">
                                        الرصيد المبدأي
                                    </td>
                                    <td style="border:1px solid black">
                                       
                                    </td>
                                    <td style="direction: ltr;">
                                        {{ formate_price($balance) }}
                                    </td>
                                </tr>
                                @foreach ($orders as $order)
                                    @if(isset($order->order_id))
                                        @php $balance  = $balance - ($order->qty * $order->price)  @endphp
                                        @php $credit  += $order->qty * $order->price @endphp
                                        <tr style="border:1px solid black">
                                            <td style="border:1px solid black">
                                                <strong>
                                                    {{ $order->order_id }}#
                                                </strong>
                                            </td>
                                            <td style="border:1px solid black">
                                                <span class="badge bg-label-primary me-1">
                                                    {{ $order->created_at }}
                                                </span>
                                            </td>
                                            <td style="border:1px solid black">
                                                مبيعات
                                            </td>
                                            <td style="border:1px solid black">
                                                {{ isset($order->product_name) ? $order->product_name : '-' }} 
                                            </td>
                                            <td style="border:1px solid black">
                                                {{ isset($order->qty) ? $order->qty : '-' }} 
                                            </td>
                                            <td style="border:1px solid black">
                                                {{ isset($order->price) ? formate_price($order->price) : '-' }} 
                                            </td>
                                            <td style="border:1px solid black">
                                                {{ isset($order->qty) ? formate_price($order->qty * $order->price) : '-' }} 
                                            </td>
                                            <td style="border:1px solid black">
                                                -
                                            </td>
                                            <td style="direction: ltr;border:1px solid black">
                                                {{ formate_price($balance) }} 
                                            </td>
                                        </tr>
                                    @elseif(isset($order->purchasing_invoices_id))
                                        @php $balance = $balance + ($order->qty * $order->price)  @endphp
                                        @php $debit  += $order->qty * $order->price @endphp
                                        <tr style="border:1px solid black">
                                            <td style="border:1px solid black">
                                                <strong>
                                                    {{ $order->purchasing_invoices_id }}#
                                                </strong>
                                            </td>
                                            <td style="border:1px solid black">
                                                <span class="badge bg-label-primary me-1">
                                                    {{ $order->created_at }}
                                                </span>
                                            </td>
                                            <td style="border:1px solid black">
                                                مشتريات
                                            </td>
                                            <td style="border:1px solid black">
                                                {{ isset($order->product_name) ? $order->product_name : '-' }} 
                                            </td>
                                            <td style="border:1px solid black">
                                                {{ isset($order->qty) ? $order->qty : '-' }} 
                                            </td>
                                            <td style="border:1px solid black">
                                                {{ isset($order->price) ? formate_price($order->price) : '-' }} 
                                            </td>
                                            <td style="border:1px solid black"> 
                                                - 
                                            </td>
                                            <td style="border:1px solid black">
                                                {{ isset($order->qty) ? formate_price($order->qty * $order->price) : '-' }}
                                            </td>
                                            <td style="direction: ltr;border:1px solid black">
                                                {{ formate_price($balance) }} 
                                            </td>
                                        </tr>
                                    @elseif(isset($order->customer_payments_id))
                                        @php $balance = $balance + $order->payment_values  @endphp
                                        @php $debit  += $order->payment_values @endphp
                                        <tr style="border:1px solid black">
                                            <td style="border:1px solid black">
                                                <strong>
                                                    -
                                                </strong>
                                            </td>
                                            <td style="border:1px solid black">
                                                <span class="badge bg-label-primary me-1">
                                                    {{ $order->created_at }}
                                                </span>
                                            </td>
                                            <td colspan="5" style="border:1px solid black">
                                                تم تحصيل كاش من العميل
                                            </td>
                                            <td style="border:1px solid black">
                                                {{ formate_price($order->payment_values) }} 
                                            </td>
                                            <td style="direction: ltr;">
                                                {{ formate_price($balance) }} 
                                            </td>
                                        </tr>
                                    @elseif(isset($order->supplier_payments_id))
                                        @php $balance = $balance - $order->payment_values  @endphp
                                        @php $credit  += $order->payment_values @endphp
                                        <tr style="border:1px solid black">
                                            <td style="border:1px solid black">
                                                <strong>
                                                    -
                                                </strong>
                                            </td>
                                            <td style="border:1px solid black">
                                                <span class="badge bg-label-primary me-1">
                                                    {{ $order->created_at }}
                                                </span>
                                            </td>
                                            <td colspan="4" style="border:1px solid black">
                                                تم دفع كاش للعميل 
                                            </td>
                                            <td colspan="2" style="border:1px solid black">
                                                {{ formate_price($order->payment_values) }} 
                                            </td>
                                            <td style="direction: ltr;">
                                                {{ formate_price($balance) }} 
                                            </td>
                                        </tr>
                                    @elseif(isset($order->returned_id))
                                        @if($order->type_return == 'sale')
                                            @php $balance = $balance + ($order->quantity * $order->price)  @endphp
                                            @php $debit  += $order->quantity * $order->price @endphp
                                        @endif
                                        @if($order->type_return == 'purchasing')
                                            @php $balance  = $balance - ($order->quantity * $order->price)  @endphp
                                            @php $credit  += $order->quantity * $order->price @endphp
                                        @endif
                                        <tr style="border:1px solid black">
                                            <td style="border:1px solid black">
                                                <strong>
                                                    {{ $order->returned_id }}#
                                                </strong>
                                            </td>
                                            <td style="border:1px solid black">
                                                <span class="badge bg-label-primary me-1">
                                                    {{ date('Y-m-d',strtotime($order->created_at)) }}
                                                </span>
                                            </td>
                                            <td style="border:1px solid black">
                                                مرتجعات من فاتورة 
                                                @if($order->type_return == 'purchasing')
                                                   شراء
                                                @endif
                                                @if($order->type_return == 'sale')
                                                   بيع
                                                @endif
                                            </td>
                                            <td style="border:1px solid black">
                                                {{ isset($order->product_name) ? $order->product_name : '-' }} 
                                            </td>
                                            <td style="border:1px solid black">
                                                {{ isset($order->quantity) ? $order->quantity : '-' }} 
                                            </td>
                                            <td style="border:1px solid black">
                                                {{ isset($order->price) ? formate_price($order->price) : '-' }} 
                                            </td>
                                            @if($order->type_return == 'purchasing')
                                                <td style="border:1px solid black">
                                                    {{ isset($order->quantity) ? formate_price($order->quantity * $order->price) : '-' }}
                                                </td>
                                                <td style="border:1px solid black">
                                                    - 
                                                </td>
                                            @endif
                                            @if($order->type_return == 'sale')
                                                <td style="border:1px solid black">
                                                    - 
                                                </td>
                                                <td style="border:1px solid black">
                                                    {{ isset($order->quantity) ? formate_price($order->quantity * $order->price) : '-' }}
                                                </td>
                                            @endif
                                            <td style="direction: ltr;border:1px solid black">
                                                {{ formate_price($balance) }} 
                                            </td>
                                        </tr>
                                    @elseif(isset($order->returns_payments_id))
                                        @if($order->type_return == 'sale')
                                            @php $balance = $balance - $order->payment_values  @endphp
                                            @php $credit  += $order->payment_values @endphp
                                        @endif
                                        @if($order->type_return == 'purchasing')
                                            @php $balance = $balance + $order->payment_values  @endphp
                                            @php $debit  += $order->payment_values @endphp
                                        @endif
                                        <tr style="border:1px solid black">
                                            <td style="border:1px solid black">
                                                <strong>
                                                    -
                                                </strong>
                                            </td>
                                            <td style="border:1px solid black">
                                                <span class="badge bg-label-primary me-1">
                                                    {{ date('Y-m-d',strtotime($order->created_at)) }}
                                                </span>
                                            </td>
                                            @if($order->type_return == 'purchasing')
                                                <td colspan="5" style="border:1px solid black">
                                                    مبلغ محصل مرتجعات لفاتورة شراء
                                                </td>
                                                <td colspan="1" style="border:1px solid black">
                                                    {{ formate_price($order->payment_values) }} 
                                                </td>
                                            @endif
    
                                            @if($order->type_return == 'sale')
                                                <td colspan="4" style="border:1px solid black">
                                                    مبلغ مدفوع مرتجعات لفاتورة بيع
                                                </td>
                                                <td colspan="2" style="border:1px solid black">
                                                    {{ formate_price($order->payment_values) }} 
                                                </td>
                                            @endif
    
                                            <td style="direction: ltr;border:1px solid black">
                                                {{ formate_price($balance) }} 
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr style="background-color: #E8F5E9;border: 4px solid #171615;">
                                    <td style="border:1px solid black">
                                        {{ date('Y-m-d h:i:s') }}
                                    </td>
                                    <td colspan="5" style="background-color: transparent !important;border:1px solid black">
                                        الرصيد الختامى
                                    </td>
                                    <td style="border:1px solid black">
                                        {{ formate_price($credit) }}
                                    </td>
                                    <td style="border:1px solid black">
                                        {{ formate_price($debit) }}
                                    </td>
                                    <td style="direction: ltr;border:1px solid black">
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