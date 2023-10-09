@extends('Theme_2.layouts.master')
@php $search = request()->query('search') ?: null;
$rows = request()->query('rows') ?: 10;
$filter = request()->query('filter') ?: null; @endphp
@section('content')
<div class="container-fluid">
   <!-- DataTales Example -->
   <div class="card mb-4">
       <div class="card">
           <h5 class="card-header">عرض الفواتير</h5>
           <div class="card-header py-3 ">
                <div class="d-flex" style="flex-direction: row-reverse;">
                    <div class="nav-item d-flex align-items-center m-2">
                        <a href="{{ route('admin.orders.create') }}" class="btn btn-success btn-md" style="color:white">اضافة فاتورة جديدة</a>
                    </div>
                </div>
               <form id="filter-data" method="get" class="d-flex justify-content-between">
                   <div class="nav-item d-flex align-items-center m-2" style="background-color: #eee;padding: 8px;">
                       <i class="bx bx-search fs-4 lh-0"></i>
                       <input type="text" class="search form-control border-0 shadow-none" placeholder="البحث ...." @isset($search) value="{{ $search }}" @endisset id="search" name="search" style="background-color: #eee;"/>
                   </div>
                   <div class="d-flex">
                       <div class="nav-item d-flex align-items-center m-2">
                           <select name="filter" id="largeSelect" onchange="document.getElementById('filter-data').submit()" class="form-control">
                                <option>فلتر الاصناف</option>
                                <option value="high-price" @isset($filter) @if ($filter=='high-price' ) selected @endif
                                    @endisset>
                                    الاعلي سعرا</option>
                                <option value="low-price" @isset($filter) @if ($filter=='low-price' ) selected @endif
                                    @endisset>
                                    الاقل سعرا</option>

                            </select>
                       </div>
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
                            <th>العميل</th>
                            <th>خصم على الفاتورة</th>
                            <th>اجمالى سعر الفاتورة</th>
                            {{-- <th>حالة الفاتورة</th> --}}
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
                                <td class="width-16">
                                    <a class="crud" href="{{ route('admin.orders.show', $order->customer->id) }}">
                                        {{ $order->customer ? $order->customer->name : '-' }}
                                    </a>
                                </td>
                                <td>
                                    {{ $order->discount }} USD
                                </td>
                                <td>
                                    {{ $order->total_price }} USD
                                </td>
                                <td>
                                    <span class="badge bg-label-primary me-1">
                                        {{ $order->created_at }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a class="crud" href="{{ route('admin.orders.show',$order->id) }}">
                                            <i class="fas fa-eye text-info"></i>
                                        </a>
                                        <a href="{{ route('admin.orders.edit',$order->id) }}" class="crud edit-product" data-product-id="{{ $order->id }}">
                                            <i class="fas fa-edit text-primary"></i>
                                        </a>
                                        <form  method="post" action="{{ route('admin.orders.destroy', $order->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a class="delete-item crud" data-order-number="{{ $order->order_number }}">
                                                <i class="fas fa-trash-alt  text-danger"></i>
                                            </a>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                   </tbody>
               </table>
           </div>
           <br/><br/>
           <div class="d-flex flex-row justify-content-center">
               {{ $orders->links() }}
           </div>
       </div>
   </div>
</div>
@endsection

@push('script')
<script>
//    jQuery('.edit-product').click(function(){
//        let product_id = jQuery(this).attr('data-product-id');
//        alert(product_id);
//        jQuery('.modalCenter').modal('show');
//        console.log(Popup);
//    });

   jQuery('.delete-item').click(function(){
       let order_number = jQuery(this).attr('data-order-number');
       if(confirm('هل متأكد من اتمام حذف الفاتورة رقم '+ order_number)){
           jQuery(this).parents('form').submit();
       }
   });
</script>
@endpush

{{-- @extends('Theme_2.layouts.master')
@php
    $search = request()->query('search') ?: null;
    $order_status = request()->query('order_status') ?: null;
    $filter = request()->query('filter') ?: null;
    $rows = request()->query('rows') ?: 10;
@endphp
@section('content')
    <div class="container-fluid">
        <h4 class="fw-bold py-3 mb-4">
            الطلبات
        </h4>
         @if (flash()->message)
            <div class="{{ flash()->class }}">
                {{ flash()->message }}
            </div>

            @if (flash()->level === 'error')
                This was an error.
            @endif
        @endif
        <!-- Basic Bootstrap Table -->
        <div class="card" style="padding-top: 3%;">
            <form id="filter-data" method="get" class="d-flex justify-content-between">
                <div class="d-flex filters-fields">
                    <div class="nav-item d-flex align-items-center m-2">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input type="text" class="search form-control border-0 shadow-none" placeholder="البحث ...."
                            @isset($search) value="{{ $search }}" @endisset id="search"
                            name="search" />
                    </div>


                </div>
                <div class="nav-item d-flex align-items-center m-2">
                    <select name="order_status" onchange="document.getElementById('filter-data').submit()" id="largeSelect"
                         class="form-control">
                        <option value="">حالة الطلب</option>
                        <option value="pending"
                            @isset($order_status) @if ($order_status == 'pending') selected @endif @endisset>
                            Pending</option>
                        <option value="not_completed"
                            @isset($order_status) @if ($order_status == 'not_completed') selected @endif @endisset>
                            Not Completed</option>

                        <option value="completed"
                            @isset($order_status) @if ($order_status == 'completed') selected @endif @endisset>
                            Completed</option>
                        <option value="cancelled"
                            @isset($order_status) @if ($order_status == 'cancelled') selected @endif @endisset>
                            Cancelled</option>
                    </select>
                </div>
                <div class="nav-item d-flex align-items-center m-2">
                    <select name="filter" id="largeSelect" onchange="document.getElementById('filter-data').submit()"
                         class="form-control">
                        <option>فلتر المنتجات</option>
                        <option value="sort_asc"
                            @isset($filter) @if ($filter == 'sort_asc') selected @endif @endisset>
                            الطلبات الاقدم</option>
                        <option value="sort_desc"
                            @isset($filter) @if ($filter == 'sort_desc') selected @endif @endisset>
                            الطلبات الأحدث</option>
                    </select>
                </div>
                <div class="d-flex">
                    <div class="nav-item d-flex align-items-center m-2">
                        <label style="padding: 0px 10px;color: #636481;">المعروض</label>
                        <select name="rows" onchange="document.getElementById('filter-data').submit()" id="largeSelect"
                            class="form-select form-select-sm">
                            <option>10</option>
                            <option value="50"
                                @isset($rows) @if ($rows == '50') selected @endif @endisset>
                                50</option>
                            <option value="100"
                                @isset($rows) @if ($rows == '100') selected @endif @endisset>
                                100</option>
                        </select>
                    </div>
                </div>
            </form>
            <br />
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>كود الطلب</th>
                            <th>الصنف</th>
                            <th>العميل</th>
                            <th>اجمالى سعر الطلبية</th>
                            <th>حالة الطلبية</th>
                            <th>تاريخ الطلبية</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td class="width-16">{{ $order->order_number }}</td>
                                <td class="width-16">
                                    @foreach ($order->orderitems as $orderitem)
                                        {{ $orderitem->product->name }}
                                    @endforeach
                                </td>

                                <td class="width-16">
                                    {{ $order->customer->name }}
                                </td>
                                <td>
                                    {{ $order->total_price }} USD
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

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <div class="d-flex flex-row justify-content-center">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
@endsection --}}
