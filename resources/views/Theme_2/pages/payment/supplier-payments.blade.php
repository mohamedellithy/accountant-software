@extends('Theme_2.layouts.master')
@php
$search = request()->query('search') ?: null;
$from = request()->query('from') ?: null;
$to = request()->query('to') ?: null;
$supplier_filter = request()->query('supplier_filter') ?: null;
$rows = request()->query('rows') ?: 10;
$filter = request()->query('filter') ?: null; @endphp
@section('content')
<div class="container-fluid">
    <br/>
    <!-- DataTales Example -->
    <div class="card mb-4">
        <div class="card">
            <h5 class="card-header"> المدفوعات / الموردين</h5>
            <div class="card-body py-3 ">

                <form id="filter-data" method="get" class=" justify-content-between">
                    <div class="d-flex justify-content-between" style="background-color: #eee;">
                        <div class="nav-item d-flex align-items-center m-2" style="background-color: #fff;padding: 2px;">
                            <i class="bx bx-search fs-4 lh-0"></i>
                            <input type="text" class="search form-control border-0 shadow-none" onblur="document.getElementById('filter-data').submit()" placeholder="البحث ...." @isset($search) value="{{ $search }}" @endisset id="search" name="search" style="background-color:#fff;"/>
                        </div>

                        <div class="nav-item d-flex align-items-center m-2">
                            <select name="supplier_filter" id="largeSelect" onchange="document.getElementById('filter-data').submit()" class="form-control form-select2">
                                <option value="">فلتر العميل</option>
                                @foreach($suppliers as  $supplier)
                                    <option value="{{ $supplier->id }}" @isset($supplier) @if ($supplier_filter == $supplier->id ) selected @endif @endisset>{{  $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="nav-item d-flex align-items-center m-2">
                            <label style="padding: 0px 5px;color: #636481;">المعروض</label>
                            <select name="rows" onchange="document.getElementById('filter-data').submit()" id="largeSelect" class="form-select form-select-sm">
                                    <option>10</option>
                                    <option value="50" @isset($rows) @if ($rows=='50' ) selected @endif @endisset>50</option>
                                    <option value="100" @isset($rows) @if ($rows=='100' ) selected @endif @endisset> 100</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead class="table-light">
                                <tr class="table-dark">
                                    <th>العميل</th>
                                    <th>اجمالى المبيعات</th>
                                    <th>اجمالى المشتريات</th>
                                    <th>مدفوعات محصلة من المورد</th>
                                    <th>مدفوعات مسددة للمورد</th>
                                    <th>مدين</th>
                                    <th>دائن</th>
                                    <th>الرصيد</th>
                                    <th></th>
                                </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                                @foreach ($suppliers as $supplier)
                                    <tr>
                                        <td>
                                            {{ $supplier->name }}
                                        </td>
                                        <td>
                                            {{ formate_price($supplier->orders_sum_total_price) }}
                                        </td>
                                        <td>
                                            {{ formate_price($supplier->purchasing_invoices_sum_total_price) }}
                                        </td>
                                        <td>
                                            {{ formate_price($supplier->customer_payments_sum_value) }}
                                        </td>
                                        <td>
                                            {{ formate_price($supplier->supplier_payments_sum_value) }}
                                        </td>
                                        <td>
                                            {{ formate_price($supplier->orders_sum_total_price - $supplier->customer_payments_sum_value) }}
                                        </td>
                                        <td>
                                            {{ formate_price($supplier->purchasing_invoices_sum_total_price - $supplier->supplier_payments_sum_value) }}
                                        </td>
                                        <td>
                                            {{  formate_price(
                                                    ($supplier->purchasing_invoices_sum_total_price - $supplier->supplier_payments_sum_value) - 
                                                    ($supplier->orders_sum_total_price - $supplier->customer_payments_sum_value) 
                                                )
                                            }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.customers.show', $supplier->id) }}">
                                                <i class="far fa-eye text-dark"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
                <br/><br/>
                <div class="d-flex flex-row justify-content-center">
                    {{ $suppliers->links() }}
                </div>
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
