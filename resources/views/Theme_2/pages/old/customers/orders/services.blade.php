@extends('layouts.master')
@php
$search = request()->query('search') ?: null;
$order_status = request()->query('order_status') ?: null;
$filter = request()->query('filter') ?: null;
$rows   = request()->query('rows')   ?: 10;
@endphp
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <h4 class="fw-bold py-3 mb-4">
                طلبات الخدمات ( {{ $customer->name }} )
            </h4>
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('admin.customers.show',$customer->id) }}"><i class="bx bx-user me-1"></i> تفاصيل الزبون</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.customers.services-orders',$customer->id) }}"><i class="bx bx-bell me-1"></i>
                     طلبات الخدمات
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.customers.products-orders',$customer->id) }}"><i
                            class="bx bx-link-alt me-1"></i>
                            طلبات المنتجات الرقمية
                    </a>
                </li>
            </ul>
        </div>
        <!-- Basic Bootstrap Table -->
        <div class="card" style="padding-top: 3%;">
            <form id="filter-data" method="get">
                <div class="d-flex filters-fields">
                    <div class="nav-item d-flex align-items-center m-2" >
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input type="text" class="search form-control border-0 shadow-none" placeholder="البحث ...."
                            @isset($search) value="{{ $search }}" @endisset id="search" name="search"/>
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
                            <th>اسم الخدمة </th>
                            <th>اسم العميل</th>
                            <th>رقم الجوال</th>
                            <th>تاريخ الاشتراك</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @foreach($application_orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td class="width-16">{{ $order->service->name }}</td>
                                <td class="width-16">
                                    {{ $order->customer->name }}
                                </td>
                                <td>
                                   {{ $order->phone }}
                                </td>
                                <td>
                                    <span class="badge bg-label-primary me-1">
                                        {{ $order->created_at }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.orders.show', $order->id) }}"><i
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
                    {{ $application_orders->links() }}
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
@endsection
