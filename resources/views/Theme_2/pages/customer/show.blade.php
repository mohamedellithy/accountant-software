<!-- Begin Page Content -->
@extends('Theme_2.layouts.master') @section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <br />
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-bell me-1"></i>
                        كشف حساب 
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.customer-payments-lists',['id' => $customer->id]) }}"><i
                            class="bx bx-link-alt me-1"></i> المدفوعات</a>
                </li>
            </ul>
            <div class="card">
                <h5 class="card-header">
                    كشف حساب {{ $customer->name }}
                </h5>
                <ul>
                    <li>
                        <a href="{{ route('admin.download-pdf-balance-bill',['id' => $customer->id]) }}" class="btn btn-success btn-sm">تنزيل كشف الحساب</a>
                    </li>
                </ul>
                <div class="table-responsive">
                    <table class="table table-border">
                        <thead class="table-light">
                            <tr class="table-dark">
                                <th>رقم الفاتورة</th>
                                <th>تاريخ الفاتورة</th>
                                <th>العملية</th>
                                <th>البيان</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>مدين</th>
                                <th>دائن</th>
                                <th>الرصيد</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <?php $balance = $customer->balance ?: 0; ?>
                            <?php $credit = 0; ?>
                            <?php $debit = 0; ?>
                            <tr>
                                <td></td>
                                <td>
                                    {{ date('Y-m-d') }}
                                </td>
                                <td colspan="5">
                                    الرصيد المبدأي
                                </td>
                                
                                <td>
                                   
                                </td>
                                <td style="direction: ltr;">
                                    {{ formate_price($balance) }}
                                </td>
                            </tr>
                            @foreach ($orders as $order)
                                @if(isset($order->order_id))
                                    @php $balance  = $balance - ($order->qty * $order->price)  @endphp
                                    @php $credit  += $order->qty * $order->price @endphp
                                    <tr>
                                        <td>
                                            <strong>
                                                {{ $order->order_id }}#
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-primary me-1">
                                                {{ date('Y-m-d',strtotime($order->created_at)) }}
                                            </span>
                                        </td>
                                        <td>
                                            مبيعات
                                        </td>
                                        <td>
                                            {{ isset($order->product_name) ? $order->product_name : '-' }} 
                                        </td>
                                        <td>
                                            {{ isset($order->qty) ? $order->qty : '-' }} 
                                        </td>
                                        <td>
                                            {{ isset($order->price) ? formate_price($order->price) : '-' }} 
                                        </td>
                                        <td>
                                            {{ isset($order->qty) ? formate_price($order->qty * $order->price) : '-' }} 
                                        </td>
                                        <td>
                                            -
                                        </td>
                                        <td style="direction: ltr;">
                                            {{ formate_price($balance) }} 
                                        </td>
                                    </tr>
                                @elseif(isset($order->purchasing_invoices_id))
                                    @php $balance = $balance + ($order->qty * $order->price)  @endphp
                                    @php $debit  += $order->qty * $order->price @endphp
                                    <tr>
                                        <td>
                                            <strong>
                                                {{ $order->purchasing_invoices_id }}#
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-primary me-1">
                                                {{ date('Y-m-d',strtotime($order->created_at)) }}
                                            </span>
                                        </td>
                                        <td>
                                            مشتريات
                                        </td>
                                        <td>
                                            {{ isset($order->product_name) ? $order->product_name : '-' }} 
                                        </td>
                                        <td>
                                            {{ isset($order->qty) ? $order->qty : '-' }} 
                                        </td>
                                        <td>
                                            {{ isset($order->price) ? formate_price($order->price) : '-' }} 
                                        </td>
                                        <td>
                                            - 
                                        </td>
                                        <td>
                                            {{ isset($order->qty) ? formate_price($order->qty * $order->price) : '-' }}
                                        </td>
                                        <td style="direction: ltr;">
                                            {{ formate_price($balance) }} 
                                        </td>
                                    </tr>
                                @elseif(isset($order->customer_payments_id))
                                    @php $balance = $balance + $order->payment_values  @endphp
                                    @php $debit  += $order->payment_values @endphp
                                    <tr>
                                        <td>
                                            <strong>
                                                -
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-primary me-1">
                                                {{ date('Y-m-d',strtotime($order->created_at)) }}
                                            </span>
                                        </td>
                                        <td colspan="5">
                                            تم تحصيل كاش من العميل
                                        </td>
                                        <td>
                                            {{ formate_price($order->payment_values) }} 
                                        </td>
                                        <td style="direction: ltr;">
                                            {{ formate_price($balance) }} 
                                        </td>
                                    </tr>
                                @elseif(isset($order->supplier_payments_id))
                                    @php $balance = $balance - $order->payment_values  @endphp
                                    @php $credit  += $order->payment_values @endphp
                                    <tr>
                                        <td>
                                            <strong>
                                                -
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-primary me-1">
                                                {{ date('Y-m-d',strtotime($order->created_at)) }}
                                            </span>
                                        </td>
                                        <td colspan="4">
                                            تم دفع كاش للعميل 
                                        </td>
                                        <td colspan="2">
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
                                    <tr>
                                        <td>
                                            <strong>
                                                {{ $order->returned_id }}#
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-primary me-1">
                                                {{ date('Y-m-d',strtotime($order->created_at)) }}
                                            </span>
                                        </td>
                                        <td>
                                            مرتجعات من فاتورة 
                                            @if($order->type_return == 'purchasing')
                                               شراء
                                            @endif
                                            @if($order->type_return == 'sale')
                                               بيع
                                            @endif
                                        </td>
                                        <td>
                                            {{ isset($order->product_name) ? $order->product_name : '-' }} 
                                        </td>
                                        <td>
                                            {{ isset($order->quantity) ? $order->quantity : '-' }} 
                                        </td>
                                        <td>
                                            {{ isset($order->price) ? formate_price($order->price) : '-' }} 
                                        </td>
                                        @if($order->type_return == 'purchasing')
                                            <td>
                                                {{ isset($order->quantity) ? formate_price($order->quantity * $order->price) : '-' }}
                                            </td>
                                            <td>
                                                - 
                                            </td>
                                        @endif
                                        @if($order->type_return == 'sale')
                                            <td>
                                                - 
                                            </td>
                                            <td>
                                                {{ isset($order->quantity) ? formate_price($order->quantity * $order->price) : '-' }}
                                            </td>
                                        @endif
                                        <td style="direction: ltr;">
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
                                    <tr>
                                        <td>
                                            <strong>
                                                -
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-label-primary me-1">
                                                {{ date('Y-m-d',strtotime($order->created_at)) }}
                                            </span>
                                        </td>
                                        @if($order->type_return == 'purchasing')
                                            <td colspan="5">
                                                مبلغ محصل مرتجعات لفاتورة شراء
                                            </td>
                                            <td colspan="1">
                                                {{ formate_price($order->payment_values) }} 
                                            </td>
                                        @endif

                                        @if($order->type_return == 'sale')
                                            <td colspan="4">
                                                مبلغ مدفوع مرتجعات لفاتورة بيع
                                            </td>
                                            <td colspan="2">
                                                {{ formate_price($order->payment_values) }} 
                                            </td>
                                        @endif

                                        <td style="direction: ltr;">
                                            {{ formate_price($balance) }} 
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr style="background-color: #E8F5E9;border: 4px solid #171615;">
                                <td>
                                    {{ date('Y-m-d') }}
                                </td>
                                <td colspan="5" style="background-color: transparent !important;">
                                    الرصيد الختامى
                                </td>
                                <td>
                                    {{ formate_price($credit) }}
                                </td>
                                <td>
                                    {{ formate_price($debit) }}
                                </td>
                                <td style="direction: ltr;">
                                    {{ formate_price($balance) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex flex-row justify-content-center">
                    {{-- {{ $orders->links() }} --}}
                </div>
            </div>
        </div>
        {{-- <div class="col-md-12">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">تفاصيل العميل</h5>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">الاسم</label>
                            <div class="input-group bg-dark text-white" style="padding: 7px;">
                                {{ $customer->name }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">التليفون</label>
                            <div class="input-group bg-dark text-white" style="padding: 7px;">
                                {{ $customer->phone }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">فواتير البيع</label>
                            <div class="input-group bg-dark text-white" style="padding: 7px;">
                                {{ $customer->orders_count }} فاتورة
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">اجمالى فواتير البيع</label>
                            <div class="input-group bg-dark text-white" style="padding: 7px;">
                                {{ formate_price($customer->orders_sum_total_price) }}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
    </div>
</div>
<!-- /.container-fluid -->
@endsection