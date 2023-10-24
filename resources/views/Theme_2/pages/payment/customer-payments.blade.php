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
    <br/>
    <!-- DataTales Example -->
    <div class="card mb-4">
        <div class="card">
            <h5 class="card-header"> المدفوعات / العملاء</h5>
            <div class="card-body py-3 ">

                <form id="filter-data" method="get" class=" justify-content-between">
                    <div class="d-flex justify-content-between" style="background-color: #eee;">
                        <div class="nav-item d-flex align-items-center m-2" style="background-color: #fff;padding: 2px;">
                            <i class="bx bx-search fs-4 lh-0"></i>
                            <input type="text" class="search form-control border-0 shadow-none" placeholder="البحث ...." @isset($search) value="{{ $search }}" @endisset id="search" name="search" style="background-color:#fff;"/>
                        </div>

                        <div class="nav-item d-flex align-items-center m-2">
                            <select name="customer_filter" id="largeSelect" onchange="document.getElementById('filter-data').submit()" class="form-control form-select2">
                                <option value="">فلتر العميل</option>
                                @foreach($customers as  $customer)
                                    <option value="{{ $customer->id }}" @isset($customer_filter) @if ($customer_filter == $customer->id ) selected @endif @endisset>{{  $customer->name }}</option>
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
                                    <th>مدفوعات محصلة من العميل</th>
                                    <th>مدفوعات مسددة للعميل</th>
                                    <th>مدين</th>
                                    <th>دائن</th>
                                    <th>الرصيد</th>
                                    <th></th>
                                </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>
                                            {{ $customer->name }}
                                        </td>
                                        <td>
                                            {{ formate_price($customer->orders_sum_total_price) }}
                                        </td>
                                        <td>
                                            {{ formate_price($customer->purchasing_invoices_sum_total_price) }}
                                        </td>
                                        <td>
                                            {{ formate_price($customer->customer_payments_sum_value) }}
                                        </td>
                                        <td>
                                            {{ formate_price($customer->supplier_payments_sum_value) }}
                                        </td>
                                        <td>
                                            {{ formate_price($customer->orders_sum_total_price - $customer->customer_payments_sum_value) }}
                                        </td>
                                        <td>
                                            {{ formate_price($customer->purchasing_invoices_sum_total_price - $customer->supplier_payments_sum_value) }}
                                        </td>
                                        <td>
                                            {{  formate_price(
                                                    ($customer->purchasing_invoices_sum_total_price - $customer->supplier_payments_sum_value) - 
                                                    ($customer->orders_sum_total_price - $customer->customer_payments_sum_value) 
                                                )
                                            }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.customers.show', $customer->id) }}">
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
                    {{ $customers->links() }}
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
