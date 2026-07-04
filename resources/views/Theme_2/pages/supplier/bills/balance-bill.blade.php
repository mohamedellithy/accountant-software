<html>
    <head>
        <meta name="google-site-verification" content="40aCnX7tt4Ig1xeLHMATAESAkTL2pn15srB14sB-EOs" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <style>
            body {
                font-family: 'dejavusans', sans-serif;
                color: #334155;
                background-color: #ffffff;
                margin: 0;
                padding: 0;
            }
            .card {
                border: none;
                background-color: #ffffff;
            }
            .header-table {
                width: 100%;
                margin-bottom: 25px;
                border-bottom: 3px solid #1e293b;
                padding-bottom: 12px;
            }
            .header-title {
                font-size: 18px;
                font-weight: bold;
                color: #1e293b;
            }
            .header-sub {
                font-size: 10px;
                color: #64748b;
                margin-top: 4px;
            }
            .date-box {
                font-size: 10px;
                color: #475569;
                text-align: left;
            }
            .statement-title-table {
                width: 100%;
                margin-bottom: 18px;
                background-color: #f1f5f9;
                border-radius: 6px;
            }
            .statement-title-td {
                padding: 10px 15px;
                font-size: 13px;
                font-weight: bold;
                color: #0f172a;
                text-align: right;
            }
            .table-container {
                width: 100%;
            }
            .table {
                width: 100%;
                border-collapse: collapse;
            }
            .table th {
                background-color: #1e293b;
                color: #ffffff;
                font-weight: bold;
                font-size: 10px;
                text-align: center;
                border: 1px solid #cbd5e1;
            }
            .table td {
                font-size: 9px;
                color: #334155;
                border: 1px solid #e2e8f0;
                text-align: center;
            }
            .badge-style {
                color: #2563eb;
                background-color: #eff6ff;
                padding: 2px 6px;
                border-radius: 4px;
                font-size: 8px;
                font-weight: bold;
            }
            .bold-text {
                font-weight: bold;
                color: #0f172a;
            }
            .initial-row {
                background-color: #f8fafc;
                font-weight: bold;
            }
            .final-row {
                background-color: #f0fdf4;
                font-weight: bold;
                color: #166534;
            }
            .final-row td {
                border-top: 2px solid #166534 !important;
                border-bottom: 2px solid #166534 !important;
                color: #166534 !important;
                font-weight: bold;
            }
            .footer-table {
                width: 100%;
                margin-top: 30px;
                margin-bottom: 20px;
            }
            .footer-td {
                border: none !important;
                font-size: 11px;
            }
            .mgmt-table {
                width: 100%;
                margin-top: 15px;
                border-top: 1px solid #cbd5e1;
                padding-top: 15px;
            }
            .mgmt-td {
                border: none !important;
                text-align: center;
            }
            .mgmt-title {
                font-weight: bold;
                color: #1e293b;
                font-size: 11px;
            }
            .mgmt-val {
                color: #64748b;
                font-size: 10px;
                margin: 3px 0 0 0;
            }
            .dev-footer {
                text-align: center;
                margin-top: 40px;
                border-top: 1px dashed #cbd5e1;
                padding-top: 12px;
                font-size: 8px;
                color: #94a3b8;
            }
        </style>
    </head>
    <body>
        <div class="card">
            <!-- Header Table -->
            <table class="header-table" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="30%" align="right" valign="middle">
                        @if(get_setting('logo'))
                            <img src="{{ public_path(get_setting('logo')) }}" style="max-height: 55px; max-width: 150px; object-fit: contain;">
                        @endif
                    </td>
                    <td width="40%" align="center" valign="middle" style="text-align: center;">
                        <span class="header-title">{{ get_setting('logo_pdf_title', env('logo_pdf_title')) }}</span>
                        <br/>
                        <span class="header-sub">(م/ت) {{ get_setting('phone_number', env('phone_number')) }} @if(get_setting('telephone')) - {{ get_setting('telephone') }} @endif</span>
                    </td>
                    <td width="30%" align="left" valign="middle" class="date-box" style="text-align: left;">
                        <strong>تحرير في:</strong> {{ date('Y-m-d') }}
                    </td>
                </tr>
            </table>

            <!-- Statement Title Bar -->
            <table class="statement-title-table" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td class="statement-title-td">
                        كشف حساب السيد / {{ $customer->name }}
                    </td>
                </tr>
            </table>

            <!-- Main Data Table -->
            <div class="table-container">
                <table class="table" cellpadding="8" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10%">رقم الفاتورة</th>
                            <th width="12%">تاريخ الفاتورة</th>
                            <th width="12%">العملية</th>
                            <th width="20%">البيان</th>
                            <th width="8%">الكمية</th>
                            <th width="10%">السعر</th>
                            <th width="9%">مدين</th>
                            <th width="9%">دائن</th>
                            <th width="10%">الرصيد</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $balance = $customer->balance ?: 0; ?>
                        <?php $credit = 0; ?>
                        <?php $debit = 0; ?>
                        
                        <!-- Initial Balance Row -->
                        <tr class="initial-row">
                            <td style="border: 1px solid #cbd5e1;">-</td>
                            <td style="border: 1px solid #cbd5e1;">{{ date('Y-m-d') }}</td>
                            <td colspan="5" style="text-align: right; border: 1px solid #cbd5e1;">الرصيد المبدأي</td>
                            <td style="border: 1px solid #cbd5e1;">-</td>
                            <td style="direction: ltr; border: 1px solid #cbd5e1;" class="bold-text">{{ formate_price($balance) }}</td>
                        </tr>

                        <?php $applied_discounts = []; $row_idx = 0; ?>
                        @foreach ($orders as $order)
                            <?php $row_bg = ($row_idx++ % 2 == 0) ? '#ffffff' : '#f8fafc'; ?>
                            
                            @if(isset($order->order_id))
                                @php $balance  = $balance - ($order->qty * $order->price)  @endphp
                                @php $credit  += $order->qty * $order->price @endphp
                                <tr style="background-color: {{ $row_bg }};">
                                    <td class="bold-text">{{ $order->order_id }}#</td>
                                    <td>
                                        <span class="badge-style">{{ date('Y-m-d',strtotime($order->created_at)) }}</span>
                                    </td>
                                    <td>مبيعات</td>
                                    <td style="text-align: right;">{{ isset($order->product_name) ? $order->product_name : '-' }}</td>
                                    <td>{{ isset($order->qty) ? $order->qty : '-' }}</td>
                                    <td>{{ isset($order->price) ? formate_price($order->price) : '-' }}</td>
                                    <td>{{ isset($order->qty) ? formate_price($order->qty * $order->price) : '-' }}</td>
                                    <td>-</td>
                                    <td style="direction: ltr;" class="bold-text">{{ formate_price($balance) }}</td>
                                </tr>
                                
                                @if(isset($order->discount) && $order->discount > 0 && !in_array($order->order_id, $applied_discounts))
                                    @php $balance = $balance + $order->discount @endphp
                                    @php $debit += $order->discount @endphp
                                    @php $applied_discounts[] = $order->order_id @endphp
                                    <?php $row_bg = ($row_idx++ % 2 == 0) ? '#ffffff' : '#f8fafc'; ?>
                                    <tr style="background-color: {{ $row_bg }};">
                                        <td class="bold-text">{{ $order->order_id }}#</td>
                                        <td>
                                            <span class="badge-style">{{ date('Y-m-d',strtotime($order->created_at)) }}</span>
                                        </td>
                                        <td>خصم مبيعات</td>
                                        <td style="text-align: right;">خصم على فاتورة مبيعات رقم {{ $order->order_id }}#</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>{{ formate_price($order->discount) }}</td>
                                        <td style="direction: ltr;" class="bold-text">{{ formate_price($balance) }}</td>
                                    </tr>
                                @endif

                            @elseif(isset($order->purchasing_invoices_id))
                                @php $balance = $balance + ($order->qty * $order->price)  @endphp
                                @php $debit  += $order->qty * $order->price @endphp
                                <tr style="background-color: {{ $row_bg }};">
                                    <td class="bold-text">{{ $order->purchasing_invoices_id }}#</td>
                                    <td>
                                        <span class="badge-style">{{ date('Y-m-d',strtotime($order->created_at)) }}</span>
                                    </td>
                                    <td>مشتريات</td>
                                    <td style="text-align: right;">{{ isset($order->product_name) ? $order->product_name : '-' }}</td>
                                    <td>{{ isset($order->qty) ? $order->qty : '-' }}</td>
                                    <td>{{ isset($order->price) ? formate_price($order->price) : '-' }}</td>
                                    <td>-</td>
                                    <td>{{ isset($order->qty) ? formate_price($order->qty * $order->price) : '-' }}</td>
                                    <td style="direction: ltr;" class="bold-text">{{ formate_price($balance) }}</td>
                                </tr>

                            @elseif(isset($order->customer_payments_id))
                                @php $balance = $balance + $order->payment_values  @endphp
                                @php $debit  += $order->payment_values @endphp
                                <tr style="background-color: {{ $row_bg }};">
                                    <td>-</td>
                                    <td>
                                        <span class="badge-style">{{ date('Y-m-d',strtotime($order->created_at)) }}</span>
                                    </td>
                                    <td colspan="5" style="text-align: right;">تم تحصيل كاش من العميل</td>
                                    <td>{{ formate_price($order->payment_values) }}</td>
                                    <td style="direction: ltr;" class="bold-text">{{ formate_price($balance) }}</td>
                                </tr>

                            @elseif(isset($order->supplier_payments_id))
                                @php $balance = $balance - $order->payment_values  @endphp
                                @php $credit  += $order->payment_values @endphp
                                <tr style="background-color: {{ $row_bg }};">
                                    <td>-</td>
                                    <td>
                                        <span class="badge-style">{{ date('Y-m-d',strtotime($order->created_at)) }}</span>
                                    </td>
                                    <td colspan="4" style="text-align: right;">
                                        @if($customer->role === 'supplier')
                                            تم دفع كاش للمورد
                                        @else
                                            تم دفع كاش للعميل
                                        @endif
                                    </td>
                                    <td>{{ formate_price($order->payment_values) }}</td>
                                    <td>-</td>
                                    <td style="direction: ltr;" class="bold-text">{{ formate_price($balance) }}</td>
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
                                <tr style="background-color: {{ $row_bg }};">
                                    <td class="bold-text">{{ $order->returned_id }}#</td>
                                    <td>
                                        <span class="badge-style">{{ date('Y-m-d',strtotime($order->created_at)) }}</span>
                                    </td>
                                    <td>
                                        مرتجعات 
                                        @if($order->type_return == 'purchasing') شراء @endif
                                        @if($order->type_return == 'sale') بيع @endif
                                    </td>
                                    <td style="text-align: right;">{{ isset($order->product_name) ? $order->product_name : '-' }}</td>
                                    <td>{{ isset($order->quantity) ? $order->quantity : '-' }}</td>
                                    <td>{{ isset($order->price) ? formate_price($order->price) : '-' }}</td>
                                    
                                    @if($order->type_return == 'purchasing')
                                        <td>{{ isset($order->quantity) ? formate_price($order->quantity * $order->price) : '-' }}</td>
                                        <td>-</td>
                                    @endif
                                    @if($order->type_return == 'sale')
                                        <td>-</td>
                                        <td>{{ isset($order->quantity) ? formate_price($order->quantity * $order->price) : '-' }}</td>
                                    @endif
                                    <td style="direction: ltr;" class="bold-text">{{ formate_price($balance) }}</td>
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
                                <tr style="background-color: {{ $row_bg }};">
                                    <td>-</td>
                                    <td>
                                        <span class="badge-style">{{ date('Y-m-d',strtotime($order->created_at)) }}</span>
                                    </td>
                                    
                                    @if($order->type_return == 'purchasing')
                                        <td colspan="5" style="text-align: right;">مبلغ محصل مرتجعات لفاتورة شراء</td>
                                        <td>{{ formate_price($order->payment_values) }}</td>
                                    @endif
                                    @if($order->type_return == 'sale')
                                        <td colspan="4" style="text-align: right;">مبلغ مدفوع مرتجعات لفاتورة بيع</td>
                                        <td>{{ formate_price($order->payment_values) }}</td>
                                        <td>-</td>
                                    @endif
                                    
                                    <td style="direction: ltr;" class="bold-text">{{ formate_price($balance) }}</td>
                                </tr>

                            @elseif(isset($order->discount_id))
                                @php $is_negative = $balance <= 0; @endphp
                                @if($is_negative)
                                    @php $balance = $balance + $order->payment_values  @endphp
                                    @php $debit += $order->payment_values @endphp
                                @else
                                    @php $balance = $balance - $order->payment_values  @endphp
                                    @php $credit += $order->payment_values @endphp
                                @endif
                                <tr style="background-color: {{ $row_bg }};">
                                    <td>-</td>
                                    <td>
                                        <span class="badge-style">{{ date('Y-m-d',strtotime($order->created_at)) }}</span>
                                    </td>
                                    <td colspan="4" style="text-align: right;">مبلغ مخصم / {{ $order->description }}</td>
                                    @if($is_negative)
                                        <td>-</td>
                                        <td>{{ formate_price($order->payment_values) }}</td>
                                    @else
                                        <td>{{ formate_price($order->payment_values) }}</td>
                                        <td>-</td>
                                    @endif
                                    <td style="direction: ltr;" class="bold-text">{{ formate_price($balance) }}</td>
                                </tr>
                            @endif
                        @endforeach

                        <!-- Final Balance Row -->
                        <tr class="final-row">
                            <td style="border: 1px solid #cbd5e1;">-</td>
                            <td style="border: 1px solid #cbd5e1;">{{ date('Y-m-d') }}</td>
                            <td colspan="4" style="text-align: right; font-weight: bold; border: 1px solid #cbd5e1;">الرصيد الختامى</td>
                            <td style="border: 1px solid #cbd5e1; font-weight: bold;">{{ formate_price($credit) }}</td>
                            <td style="border: 1px solid #cbd5e1; font-weight: bold;">{{ formate_price($debit) }}</td>
                            <td style="direction: ltr; font-weight: bold; border: 1px solid #cbd5e1;">{{ formate_price($balance) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Signatures Table -->
            <table class="footer-table" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="50%" align="right" valign="middle" class="footer-td" style="text-align: right;">
                        <strong style="color: #1e293b;">المستلم /</strong>
                        <span style="color: #334155;">{{ $customer->name }}</span>
                    </td>
                    <td width="50%" align="left" valign="middle" class="footer-td" style="text-align: left;">
                        <strong style="color: #1e293b;">التوقيع /</strong>
                        <span style="color: #cbd5e1;">............................................................</span>
                    </td>
                </tr>
            </table>

            <!-- Management Details Table -->
            <table class="mgmt-table" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="50%" align="center" class="mgmt-td">
                        <span class="mgmt-title">الإدارة</span>
                        <p class="mgmt-val">م . {{ get_setting('manager_name', env('manager_name')) }}</p>
                    </td>
                    <td width="50%" align="center" class="mgmt-td">
                        <span class="mgmt-title">رقم التليفون</span>
                        <p class="mgmt-val">{{ get_setting('phone_number', env('phone_number')) }} @if(get_setting('telephone')) / {{ get_setting('telephone') }} @endif</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Developer Credit Footer -->
        <div class="dev-footer">
            <span>تم تطوير هذا النظام بواسطة <strong>multi-solutions</strong> لحلول البرمجيات وتكنولوجيا المعلومات</span>
            <br/>
            <span>واتساب / جوال: 201026051966 - 201080766906</span>
        </div>
    </body>
</html>