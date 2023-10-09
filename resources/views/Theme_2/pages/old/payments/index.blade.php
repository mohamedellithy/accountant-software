@extends('layouts.master')
@php
$search = request()->query('search') ?: null;
$status_payment = request()->query('status_payment') ?: null;
$filter = request()->query('filter') ?: null;
$rows   = request()->query('rows')   ?: 10;
@endphp
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            الطلبات
        </h4>
        <!-- Basic Bootstrap Table -->
        <div class="card" style="padding-top: 3%;">
            <form id="filter-data" method="get">
                <div class="d-flex filters-fields">
                    <div class="nav-item d-flex align-items-center m-2" >
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input type="text" class="search form-control border-0 shadow-none" placeholder="البحث ...."
                            @isset($search) value="{{ $search }}" @endisset id="search" name="search"/>
                    </div>
                    <div class="nav-item d-flex align-items-center m-2" >
                        <select name="status_payment" onchange="document.getElementById('filter-data').submit()" id="largeSelect" class="form-select form-select-md">
                            <option value="">حالة الطلب</option>
                            <option value="paid"       @isset($status_payment) @if($status_payment == 'paid') selected @endif @endisset>PAID</option>
                            <option value="failed"     @isset($status_payment) @if($status_payment == 'failed') selected @endif @endisset>FAILED</option>
                            <option value="on-paid"    @isset($status_payment) @if($status_payment == 'on-paid') selected @endif @endisset>NO-PAID</option>
                        </select>
                    </div>
                    <div class="nav-item d-flex align-items-center m-2" >
                        <select name="filter" id="largeSelect"  onchange="document.getElementById('filter-data').submit()" class="form-select form-select-md">
                            <option>فلتر المنتجات</option>
                            <option value="sort_asc"   @isset($filter) @if($filter == 'sort_asc') selected @endif @endisset>الطلبات الاقدم</option>
                            <option value="sort_desc"  @isset($filter) @if($filter == 'sort_desc') selected @endif @endisset>الطلبات الأحدث</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="nav-item d-flex align-items-center m-2" >
                        <label style="padding: 0px 10px;color: #636481;">المعروض</label>
                        <select name="rows" onchange="document.getElementById('filter-data').submit()" id="largeSelect" class="form-select form-select-sm">
                            <option>10</option>
                            <option value="50" @isset($rows) @if($rows == '50') selected @endif @endisset>50</option>
                            <option value="100" @isset($rows) @if($rows == '100') selected @endif @endisset>100</option>
                        </select>
                    </div>
                </div>
            </form>
            <br/>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>كود الطلبية</th>
                            <th>العميل</th>
                            <th>اجمالى المدفوعات</th>
                            <th>رقم العملية</th>
                            <th>حالة المدفوعات</th>
                            <th>بوابة الدفع</th>
                            <th>تاريخ العملية</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>{{ $payment->order->order_no }}</td>
                                <td>{{ $payment->order->customer->name }}</td>
                                <td>{{ formate_price($payment->total_payment) }}</td>
                                <td>{{ $payment->transaction_id }}</td>
                                <td>
                                    <span class="badge bg-label-danger me-1">
                                        {{ $payment->status_payment }}
                                    </span>
                                </td>
                                <td>{{ $payment->getaway }}</td>
                                <td>
                                    <span class="badge bg-label-primary me-1">
                                        {{ $payment->created_at }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.orders.show', $payment->order->order_no) }}"><i
                                                    class="fa-regular fa-eye me-2"></i></i>
                                                عرض
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br/>
                <div class="d-flex flex-row justify-content-center">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
@endsection
