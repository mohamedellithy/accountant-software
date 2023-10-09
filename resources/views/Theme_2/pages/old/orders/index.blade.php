@extends('layouts.master')
@php
$search = request()->query('search') ?: null;
$order_status = request()->query('order_status') ?: null;
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
                        <select name="order_status" onchange="document.getElementById('filter-data').submit()" id="largeSelect" class="form-select form-select-md">
                            <option value="">حالة الطلب</option>
                            <option value="pending"    @isset($order_status) @if($order_status == 'pending') selected @endif @endisset>Pending</option>
                            <option value="processing" @isset($order_status) @if($order_status == 'processing') selected @endif @endisset>Processing</option>
                            <option value="on-hold"    @isset($order_status) @if($order_status == 'on-hold') selected @endif @endisset>on-hold</option>
                            <option value="completed"  @isset($order_status) @if($order_status == 'completed') selected @endif @endisset>Completed</option>
                            <option value="cancelled"  @isset($order_status) @if($order_status == 'cancelled') selected @endif @endisset>Cancelled</option>
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
                            <th>المنتج</th>
                            <th>العميل</th>
                            <th>اجمالى سعر الطلبية</th>
                            <th>حالة الطلبية</th>
                            <th>تاريخ الطلبية</th>
                            <th>مقروء</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td class="width-16">{{ $order->order_no }}</td>
                                <td class="width-16">
                                    {{ $order->order_items ? $order->order_items->product->name : '-' }}
                                </td>
                                <td class="width-16">
                                    {{ $order->customer->name }}
                                </td>
                                <td>
                                   {{ $order->order_total }} USD
                                </td>
                                <td>
                                    <span class="badge bg-label-info me-1">
                                        {{ $order->order_status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-label-primary me-1">
                                        {{ $order->created_at }}
                                    </span>
                                </td>
                                <td>
                                    @if($order->read == 0)
                                        <i class='bx bxs-circle' style="font-size: 12px;color:red" title="غير مقروء بعد"></i>
                                    @elseif($order->read == 1)
                                        <i class='bx bxs-circle' style="font-size: 12px;color:#dcadad" title="مقروء"></i>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu">
                                            {{-- <a class="dropdown-item"
                                                href="{{ route('admin.orders.edit', $order->order_no) }}"><i
                                                    class="bx bx-edit-alt me-2"></i>
                                                تعديل
                                            </a> --}}
                                            <a class="dropdown-item"
                                                href="{{ route('admin.orders.show', $order->order_no) }}"><i
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
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
@endsection
