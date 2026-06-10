@extends('Theme_2.layouts.master')

@section('content')
<div class="container-fluid"><br/>
    <!-- Breadcrumb -->
    <h4 class="py-3 mb-4 fw-bold">
        <span class="text-muted fw-light">التقارير المالية /</span> المطلوب تحصيله من العملاء
    </h4>

    <!-- Summary Box -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-label-success border-start border-success border-3">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title text-success mb-1 fw-bold">
                            <i class="bx bx-money me-2"></i>إجمالي المطلوب تحصيله من العملاء
                        </h5>
                        <p class="card-text text-muted mb-0">مجموع المبالغ المستحقة على العملاء الذين لديهم رصيد بالسالب</p>
                    </div>
                    <div class="text-end">
                        <h2 class="text-success mb-0 fw-bold">{{ formate_price($total_debts) }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Action Form -->
    <div class="card mb-4 print-hide">
        <div class="card-body">
            <form id="filter-data" method="GET" action="{{ route('admin.customers.debts') }}" class="row g-3 align-items-center">
                <div class="col-12 col-md-5">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="search" class="form-control form-control-lg" placeholder="البحث باسم العميل..." value="{{ $search }}">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <button type="submit" class="btn btn-primary w-100 py-2"><i class="bx bx-filter-alt me-1"></i>بحث</button>
                </div>
                <div class="col-12 col-md-2">
                    <a href="{{ route('admin.customers.debts.pdf', ['search' => $search]) }}" class="btn btn-outline-danger w-100 py-2"><i class="bx bxs-file-pdf me-1"></i>تنزيل PDF</a>
                </div>
                <div class="col-12 col-md-2">
                    <button type="button" onclick="printDiv('print-area')" class="btn btn-outline-success w-100 py-2"><i class="bx bx-printer me-1"></i>طباعة</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Details -->
    <div class="card mb-4" id="print-area">
        <!-- Print Header (Hidden on Screen, Visible on Print) -->
        <div class="print-header" style="display: none;">
            <table style="width: 100%; border: none; margin-bottom: 20px;">
                <tr>
                    <td style="text-align: right; width: 60%; border: none;">
                        @if(get_setting('logo'))
                            <img src="{{ asset(get_setting('logo')) }}" alt="Logo" style="max-height: 55px; max-width: 150px; object-fit: contain;">
                        @endif
                        <div style="margin-top: 5px;">
                            <strong style="font-size: 15px;">{{ get_setting('logo_pdf_title', env('logo_pdf_title')) }}</strong>
                            <p style="margin: 3px 0 0 0; font-size: 11px;">(م/ت) {{ get_setting('phone_number', env('phone_number')) }} @if(get_setting('telephone')) - {{ get_setting('telephone') }} @endif</p>
                        </div>
                    </td>
                    <td style="text-align: left; width: 40%; border: none; font-size: 11px; vertical-align: top;">
                        <strong>تاريخ الطباعة: </strong> {{ date('Y-m-d') }}
                    </td>
                </tr>
            </table>
            <hr style="border-top: 1px solid #ccc; margin: 15px 0;"/>
            <div style="text-align: center; margin-bottom: 20px;">
                <h3 style="color: #2e7d32; margin: 0; font-weight: bold;">تقرير المبالغ المطلوب تحصيله من العملاء</h3>
            </div>
            <div style="text-align: center; margin-bottom: 20px; border: 1px solid #2e7d32; background-color: #e8f5e9; padding: 10px; font-weight: bold; color: #2e7d32; font-size: 15px;">
                إجمالي المطلوب تحصيله: {{ formate_price($total_debts) }}
            </div>
        </div>

        <style>
            @media print {
                body {
                    direction: rtl !important;
                    background: #fff !important;
                }
                .print-header {
                    display: block !important;
                }
                .print-hide {
                    display: none !important;
                }
                .table {
                    width: 100% !important;
                    border-collapse: collapse !important;
                    margin-top: 10px !important;
                }
                .table th, .table td {
                    border: 1px solid #444 !important;
                    padding: 8px !important;
                    text-align: center !important;
                    font-size: 12px !important;
                    color: #000 !important;
                }
                .table th {
                    background-color: #e8f5e9 !important;
                    color: #1b5e20 !important;
                    font-weight: bold !important;
                }
                .text-danger {
                    color: #000 !important;
                    font-weight: bold !important;
                }
            }
        </style>

        <h5 class="card-header fw-bold text-dark"><i class="bx bx-list-ol me-2"></i>تفاصيل مستحقات العملاء</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="table-dark">
                        <th>#</th>
                        <th>كود العميل</th>
                        <th>اسم العميل</th>
                        <th>رقم الهاتف</th>
                        <th>الرصيد المبدأي</th>
                        <th>المبلغ المطلوب تحصيله</th>
                        <th>تاريخ آخر حركة</th>
                        <th class="print-hide text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
                            <td><span class="badge bg-label-secondary fw-semibold">{{ $customer->id }}</span></td>
                            <td class="fw-bold">{{ $customer->name }}</td>
                            <td>{{ $customer->phone ?: '-' }}</td>
                            <td>{{ formate_price($customer->balance) }}</td>
                            <td class="text-danger fw-bold">{{ formate_price(abs($customer->current_balance)) }}</td>
                            <td>{{ $customer->last_transaction_date }}</td>
                            <td class="print-hide text-center">
                                <div class="d-flex justify-content-center">
                                    <a class="btn btn-sm btn-outline-success" href="{{ route('admin.customers.show', $customer->id) }}">
                                        <i class="bx bx-show me-1"></i> عرض كشف الحساب
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">لا توجد مستحقات مطلوبة للعملاء حالياً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
            <div class="card-footer d-flex justify-content-center print-hide border-top">
                {{ $customers->links('Theme_2.inc.custom_pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
