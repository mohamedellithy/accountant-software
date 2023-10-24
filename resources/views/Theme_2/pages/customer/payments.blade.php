<!-- Begin Page Content -->
@extends('Theme_2.layouts.master') @section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <br />
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link {{ IsActiveOnlyIf(['admin.customers.show']) }}" href="{{ route('admin.customers.show',$customer->id) }}"><i class="bx bx-bell me-1"></i>
                        كشف حساب 
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ IsActiveOnlyIf(['admin.customer-payments-lists']) }}" href="{{ route('admin.customer-payments-lists',['id' => $customer->id]) }}"><i
                            class="bx bx-link-alt me-1"></i> المدفوعات</a>
                </li>
            </ul>
            <div class="card">
                <h5 class="card-header">
                    مدفوعات العميل {{ $customer->name }}
                </h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-border">
                        <thead class="table-light">
                            <tr class="table-dark">
                                <th>تاريخ العملية</th>
                                <th>قيمة الدفعة</th>
                                <th>نوع العملية</th>
                                <th>رقم الفاتورة</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>
                                        {{ $payment->created_at }}
                                    </td>
                                    <td>
                                        {{ formate_price($payment->value) }}
                                    </td>
                                    <td>
                                        @if(isset($payment->s_invoice_id) && !isset($payment->p_invoice_id))
                                            محصل من العميل قيمة مبيعات 
                                        @elseif(!isset($payment->s_invoice_id) && !isset($payment->p_invoice_id))
                                            بدون فاتورة
                                        @elseif(!isset($payment->s_invoice_id) && isset($payment->p_invoice_id))
                                            مدفوع للعميل قيمة مشتريات
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($payment->s_invoice_id))
                                            {{ ' # '.$payment->s_invoice_id }}
                                        @elseif(isset($payment->p_invoice_id))
                                            {{ ' # '.$payment->p_invoice_id }}
                                        @else
                                            {{ '-' }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex flex-row justify-content-center">
                    {{-- {{ $payments->links() }} --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection