@extends('Theme_2.layouts.master')
@php
$search = request()->query('search') ?: null;
$from = request()->query('from') ?: null;
$to = request()->query('to') ?: null;
$customer_filter = request()->query('customer_filter') ?: null;
$rows = request()->query('rows') ?: 10;
$filter = request()->query('filter') ?: null; @endphp
@section('content')
<div class="container-fluid">
   <!-- DataTales Example -->
   <div class="card mb-4">
        <div class="card">
            <h5 class="card-header">عرض فواتير الشراء</h5>
            <div class="card-body py-3 card-body-mo">
                <div class="d-flex" style="flex-direction: row-reverse;">
                    <div class="nav-item d-flex align-items-center m-2">
                        <a href="{{ route('admin.purchasing-invoices.create') }}" class="btn btn-success btn-md" style="color:white">اضافة فاتورة جديدة</a>
                    </div>
                </div>
                <form id="filter-data" method="get" class=" justify-content-between">
                    <div class="d-flex justify-content-between" style="background-color: #eee;">
                        <div class="nav-item d-flex align-items-center m-2" style="background-color: #fff;padding: 2px;">
                            <i class="bx bx-search fs-4 lh-0"></i>
                            <input type="text" class="search form-control border-0 shadow-none" placeholder="البحث ...." @isset($search) value="{{ $search }}" @endisset id="search" name="search" style="background-color:#fff;"/>
                        </div>

                        {{-- <div class="nav-item d-flex align-items-center m-2">
                            <select name="customer_filter" id="largeSelect" onchange="document.getElementById('filter-data').submit()" class="form-control form-select2">
                                <option value="">فلتر العميل</option>
                                @foreach (  $customers as  $customer)
                                    <option value="{{ $customer->id }}" @isset($customer_filter) @if ($customer_filter == $customer->id ) selected @endif @endisset>{{  $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="nav-item d-flex align-items-center m-2">
                            <label style="color: #636481;">من:</label><br>
                            <input type="date" onchange="document.getElementById('filter-data').submit()" class=" form-control" placeholder="من ...." @isset($from) value="{{ $from }}" @endisset id="from" name="from"/>&ensp;
                                <label style="color: #636481;">الي:</label><br>
                            <input type="date" onchange="document.getElementById('filter-data').submit()" class=" form-control" placeholder="الي ...." @isset($to) value="{{ $to }}" @endisset id="to" name="to"/>
                        </div>
                        <div class="nav-item d-flex align-items-center m-2">
                            <select name="filter" id="largeSelect" onchange="document.getElementById('filter-data').submit()" class="form-control">
                                <option value="">فلتر الاصناف</option>
                                <option value="high-price" @isset($filter) @if ($filter=='high-price' ) selected @endif @endisset> الاعلي سعرا</option>
                                <option value="low-price" @isset($filter) @if ($filter=='low-price' ) selected @endif @endisset>الاقل سعرا</option>
                            </select>
                        </div>
                        <div class="nav-item d-flex align-items-center m-2">
                            <label style="padding: 0px 5px;color: #636481;">المعروض</label>
                            <select name="rows" onchange="document.getElementById('filter-data').submit()" id="largeSelect" class="form-select form-select-sm">
                                    <option>10</option>
                                    <option value="50" @isset($rows) @if ($rows=='50' ) selected @endif @endisset>50</option>
                                    <option value="100" @isset($rows) @if ($rows=='100' ) selected @endif @endisset> 100</option>
                            </select>
                        </div> --}}
                    </div>
                </form>

                <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                            <tr class="table-dark">
                                <th>كود الفاتورة</th>
                                <th>العميل</th>
                                <th>اجمالى سعر الفاتورة</th>
                                <th>عدد الاصناف</th>
                                <th>حالة الفاتورة</th>
                                <th>المدفوع</th>
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
                                        <a class="crud" href="{{ route('admin.suppliers.show', $order->supplier->id) }}">
                                            {{ $order->supplier ? $order->supplier->name : '-' }}
                                        </a>
                                    </td>
                                    <td>
                                        {{  formate_price($order->total_price) }}
                                    </td>
                                    <td>
                                        {{ $order->quantity }} صنف
                                    </td>
                                    <td>
                                        {{ $order->payment_type == 'cashe' ? 'كاش' : 'دفعات' }}
                                    </td>
                                    <td>
                                        {{ formate_price($order->invoice_payments_sum_value) }}
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary me-1">
                                            {{ $order->created_at }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="crud" href="{{ route('admin.purchasing-invoices.show',$order->id) }}">
                                                <i class="fas fa-eye text-info"></i>
                                            </a>
                                            <a href="{{ route('admin.purchasing-invoices.edit',$order->id) }}" class="crud edit-product" data-product-id="{{ $order->id }}">
                                                <i class="fas fa-edit text-primary"></i>
                                            </a>
                                            <form  method="post" action="{{ route('admin.purchasing-invoices.destroy', $order->id) }}">
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
                    {{ $orders->onEachSide(2)->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    @media(max-width:1000px){
        .card-body-mo{
            padding: 4px 4px !important;
        }
    }
</style>
@endpush

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
