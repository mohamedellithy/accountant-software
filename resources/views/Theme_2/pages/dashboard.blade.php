@extends('Theme_2.layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Welcome Header Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card overflow-hidden" style="border: none; background: linear-gradient(135deg, #059669 0%, #1e293b 100%) !important; box-shadow: 0 8px 20px rgba(5, 150, 105, 0.15) !important;">
                <div class="card-body p-4 text-white text-end">
                    <div class="row align-items-center">
                        <div class="col-md-9 text-start">
                            <h3 class="fw-bold mb-1 text-white" style="font-family: 'Cairo', sans-serif !important;">نظام الندى للتنمية الزراعية المحاسبي</h3>
                            <p class="mb-0 opacity-80" style="font-size: 14px; font-family: 'Cairo', sans-serif !important;">مرحباً بك مجدداً في لوحة المتابعة المالية الفورية وإدارة المخازن والمبيعات الشاملة.</p>
                        </div>
                        <div class="col-md-3 text-end d-none d-md-block">
                            <i class="bx bx-trending-up text-white" style="font-size: 70px; opacity: 0.15;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Financial Highlight Cards -->
    <div class="row mb-3">
        <!-- Collectable Card -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card h-100 shadow-sm" style="border-right: 5px solid #10b981 !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar p-2 rounded" style="background-color: rgba(16, 185, 129, 0.1);">
                            <i class="bx bx-receipt text-success fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted d-block mb-1" style="font-size: 13px; font-weight: 600;">المطلوب تحصيله من العملاء</span>
                        <h4 class="card-title mb-1 text-success fw-bold" style="font-size: 20px;">
                            {{ formate_price($total_must_collect) }}
                        </h4>
                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                            <small class="text-muted">مستحقات آجلة</small>
                            <a href="{{ route('admin.customers.debts') }}" class="btn btn-xs btn-label-success py-1">
                                عرض التقرير <i class="bx bx-left-arrow-alt ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Payable Card -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card h-100 shadow-sm" style="border-right: 5px solid #ef4444 !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar p-2 rounded" style="background-color: rgba(239, 68, 68, 0.1);">
                            <i class="bx bx-credit-card-front text-danger fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted d-block mb-1" style="font-size: 13px; font-weight: 600;">المطلوب تسديده للموردين</span>
                        <h4 class="card-title mb-1 text-danger fw-bold" style="font-size: 20px;">
                            {{ formate_price($total_must_paid) }}
                        </h4>
                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                            <small class="text-muted">التزامات محاسبية</small>
                            <a href="{{ route('admin.suppliers.debts') }}" class="btn btn-xs btn-label-danger py-1">
                                عرض التقرير <i class="bx bx-left-arrow-alt ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stock Value Card -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card h-100 shadow-sm" style="border-right: 5px solid #3b82f6 !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar p-2 rounded" style="background-color: rgba(59, 130, 246, 0.1);">
                            <i class="bx bx-store-alt text-info fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted d-block mb-1" style="font-size: 13px; font-weight: 600;">إجمالي قيمة المخزون الحالي</span>
                        <h4 class="card-title mb-1 text-info fw-bold" style="font-size: 20px;">
                            {{ formate_price($cost_total_stocks) }}
                        </h4>
                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                            <small class="text-muted">قيمة البضاعة</small>
                            <a href="{{ route('admin.stocks.index') }}" class="btn btn-xs btn-label-info py-1">
                                عرض المخزن <i class="bx bx-left-arrow-alt ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Expenses Card -->
        <div class="col-lg-3 col-md-6 col-12 mb-4">
            <div class="card h-100 shadow-sm" style="border-right: 5px solid #f59e0b !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="avatar p-2 rounded" style="background-color: rgba(245, 158, 11, 0.1);">
                            <i class="bx bx-wallet text-warning fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-muted d-block mb-1" style="font-size: 13px; font-weight: 600;">إجمالي المصروفات</span>
                        <h4 class="card-title mb-1 text-warning fw-bold" style="font-size: 20px;">
                            {{ formate_price($expenses_total) }}
                        </h4>
                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                            <small class="text-muted">المصاريف التشغيلية</small>
                            <a href="{{ route('admin.expenses.index') }}" class="btn btn-xs btn-label-warning py-1">
                                عرض المصروفات <i class="bx bx-left-arrow-alt ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Apex Financial Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom py-3">
                    <div>
                        <h5 class="card-title mb-0 fw-bold" style="color: #1e293b;"><i class="bx bx-bar-chart-alt-2 text-success me-2"></i>تحليل التدفقات النقدية والحركة المالية</h5>
                        <small class="text-muted">مقارنة بصرية شاملة لأحجام المبيعات، المشتريات، المقبوضات والمدفوعات</small>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div id="cashflowChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Details Sections Grid -->
    <div class="row">
        <!-- Stock Details Card -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0 fw-bold" style="color: #1e293b;"><i class="bx bx-box text-primary me-2"></i>حركة المخازن والمنتجات</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-barcode-reader text-muted fs-4 me-3"></i>
                                <div>
                                    <span class="d-block fw-semibold text-dark">عدد الأصناف</span>
                                    <small class="text-muted">إجمالي المنتجات المسجلة</small>
                                </div>
                            </div>
                            <span class="badge bg-label-primary rounded p-2 fw-bold" style="font-size: 14px;">{{ $count_products }} صنف</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-store-alt text-muted fs-4 me-3"></i>
                                <div>
                                    <span class="d-block fw-semibold text-dark">المستودع الفعلي</span>
                                    <small class="text-muted">مواقع مخزنية نشطة</small>
                                </div>
                            </div>
                            <span class="badge bg-label-secondary rounded p-2 fw-bold" style="font-size: 14px;">{{ $count_stocks }} أصناف</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-error text-danger fs-4 me-3"></i>
                                <div>
                                    <span class="d-block fw-semibold text-dark">المنتجات المنتهية</span>
                                    <small class="text-muted">الكميات التي بلغت الصفر أو أقل</small>
                                </div>
                            </div>
                            <span class="badge {{ $count_low_of_stock > 0 ? 'bg-label-danger' : 'bg-label-success' }} rounded p-2 fw-bold" style="font-size: 14px;">
                                {{ $count_low_of_stock }} منتج
                            </span>
                        </li>
                    </ul>
                    <div class="p-3 text-center">
                        <a href="{{ route('admin.stocks.index') }}" class="btn btn-outline-primary btn-sm w-100 py-2">عرض جرد المخزن بالكامل</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices & Sales Card -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0 fw-bold" style="color: #1e293b;"><i class="bx bx-receipt text-success me-2"></i>الفواتير والمبيعات</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-trending-up text-success fs-4 me-3"></i>
                                <div>
                                    <span class="d-block fw-semibold text-dark">إجمالي فواتير البيع</span>
                                    <small class="text-muted">المبيعات الإجمالية للعملاء</small>
                                </div>
                            </div>
                            <span class="text-success fw-bold" style="font-size: 14.5px;">{{ formate_price($sales_total) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-trending-down text-danger fs-4 me-3"></i>
                                <div>
                                    <span class="d-block fw-semibold text-dark">إجمالي فواتير الشراء</span>
                                    <small class="text-muted">المشتريات الإجمالية من الموردين</small>
                                </div>
                            </div>
                            <span class="text-danger fw-bold" style="font-size: 14.5px;">{{ formate_price($purchasing_total) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-redo text-warning fs-4 me-3"></i>
                                <div>
                                    <span class="d-block fw-semibold text-dark">إجمالي المرتجعات</span>
                                    <small class="text-muted">البضائع المسترجعة من المبيعات</small>
                                </div>
                            </div>
                            <span class="text-warning fw-bold" style="font-size: 14.5px;">{{ formate_price($return_total) }}</span>
                        </li>
                    </ul>
                    <div class="p-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-success btn-sm w-100 py-2">فواتير البيع</a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.purchasing-invoices.index') }}" class="btn btn-outline-danger btn-sm w-100 py-2">فواتير الشراء</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stakeholders & Payments Card -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="card-title mb-0 fw-bold" style="color: #1e293b;"><i class="bx bx-group text-warning me-2"></i>الشركاء والمدفوعات</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-user text-muted fs-4 me-3"></i>
                                <div>
                                    <span class="d-block fw-semibold text-dark">العملاء والمدفوعات</span>
                                    <small class="text-muted">العملاء: {{ $customer_counts }} | المقبوضات:</small>
                                </div>
                            </div>
                            <span class="text-success fw-bold" style="font-size: 14px;">{{ formate_price($customer_payments_total) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex align-items-center">
                                <i class="bx bxs-truck text-muted fs-4 me-3"></i>
                                <div>
                                    <span class="d-block fw-semibold text-dark">الموردين والمدفوعات</span>
                                    <small class="text-muted">الموردين: {{ $supplier_counts }} | المدفوعات:</small>
                                </div>
                            </div>
                            <span class="text-danger fw-bold" style="font-size: 14px;">{{ formate_price($supplier_payments_total) }}</span>
                        </li>
                    </ul>
                    <div class="p-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-primary btn-sm w-100 py-2">دليل العملاء</a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary btn-sm w-100 py-2">دليل الموردين</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            series: [{
                name: 'الإجمالي (جنيه)',
                data: [
                    {{ $sales_total }},
                    {{ $purchasing_total }},
                    {{ $customer_payments_total }},
                    {{ $supplier_payments_total }},
                    {{ $expenses_total }}
                ]
            }],
            chart: {
                type: 'bar',
                height: 350,
                fontFamily: 'Cairo, sans-serif',
                toolbar: {
                    show: false
                }
            },
            colors: ['#059669', '#ef4444', '#10b981', '#f59e0b', '#ef4444'],
            plotOptions: {
                bar: {
                    colorByPoint: true,
                    borderRadius: 6,
                    columnWidth: '45%',
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return parseFloat(val).toLocaleString('ar-EG') + " ج.م";
                },
                style: {
                    fontSize: '11px',
                    colors: ["#fff"]
                }
            },
            grid: {
                show: true,
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
            },
            xaxis: {
                categories: ['إجمالي المبيعات', 'إجمالي المشتريات', 'المحصل من العملاء', 'المدفوع للموردين', 'إجمالي المصروفات'],
                labels: {
                    style: {
                        fontSize: '11px',
                        fontWeight: 600,
                        colors: '#64748b'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'القيمة المالية (ج.م)',
                    style: {
                        fontFamily: 'Cairo, sans-serif',
                        fontWeight: 600,
                        color: '#64748b'
                    }
                },
                labels: {
                    formatter: function (val) {
                        return parseFloat(val).toLocaleString('ar-EG');
                    },
                    style: {
                        colors: '#64748b'
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return parseFloat(val).toLocaleString('ar-EG') + " ج.م";
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#cashflowChart"), options);
        chart.render();
    });
</script>
@endpush
