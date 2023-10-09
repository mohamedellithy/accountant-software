<!-- Begin Page Content -->
@extends('Theme_2.layouts.master') @section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <br />
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $customer->name }}</h1>
    </div>
    <div class="row">
        <div class="col-md-9">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-bell me-1"></i> فواتير
                        البيع</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages-account-settings-notifications.html"><i class="bx bx-bell me-1"></i>
                        فواتير الشراء</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages-account-settings-connections.html"><i
                            class="bx bx-link-alt me-1"></i> المديونية</a>
                </li>
            </ul>
            <div class="card">
                <h5 class="card-header">فواتير البيع</h5>
                <div class="card-header py-3 ">
                    <form id="filter-data" method="get" class="d-flex justify-content-between">
                        <div class="nav-item d-flex align-items-center m-2" style="background-color: #eee;padding: 8px;">
                            <i class="bx bx-search fs-4 lh-0"></i>
                            <input type="text" class="search form-control border-0 shadow-none" placeholder="البحث ...." @isset($search) value="{{ $search }}" @endisset id="search" name="search" style="background-color: #eee;" />
                        </div>
                        <div class="d-flex">
                            <div class="nav-item d-flex align-items-center m-2">
                                <label style="padding: 0px 10px;color: #636481;">المعروض</label>
                                <select name="rows" onchange="document.getElementById('filter-data').submit()" id="largeSelect" class="form-select form-select-sm">
                                    <option>10</option>
                                    <option value="50" @isset($rows) @if ($rows=='50' ) selected @endif @endisset>
                                        50</option>
                                    <option value="100" @isset($rows) @if ($rows=='100' ) selected @endif @endisset>
                                        100</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead class="table-light">
                            <tr class="table-dark">
                                <th>كود الفاتورة</th>
                                <th>سعر الفاتورة</th>
                                <th>خصم على الفاتورة</th>
                                <th>سعر نهائي الفاتورة</th>
                                <th>تاريخ الفاتورة</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($orders as $order)
                            <tr>
                                <td class="width-16">
                                    <strong>
                                        {{ $order->order_number }}#
                                    </strong>
                                </td>
                                 <td>
                                    {{ formate_price($order->sub_total) }} 
                                </td>
                                <td>
                                    {{ formate_price($order->discount) }} 
                                </td>
                                <td>
                                    {{ formate_price($order->total_price) }} 
                                </td>
                                {{--
                                <td>
                                    <span class="badge bg-label-info me-1">
                                             {{ $order->order_status }}
                                </span>
                                </td> --}}
                                <td>
                                    <span class="badge bg-label-primary me-1">
                                        {{ $order->created_at }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a class="crud edit-product" data-product-id="{{ $order->id }}">
                                            <i class="fas fa-eye text-info"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex flex-row justify-content-center">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
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
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection