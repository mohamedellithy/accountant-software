<!-- Begin Page Content -->
@extends('Theme_2.layouts.master')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <br />
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link @if(request('type') != 'invoices') active @endif" href="{{ route('admin.products.show',['product' => $product->id,'type' => 'sale']) }}"><i class="bx bx-bell me-1"></i>
                        تفاصيل مبيعات الصنف
                    </a>
                </li>
                <li class="nav-item" style="margin-right:10px">
                    <a class="nav-link  @if(request('type') == 'invoices') active @endif" href="{{ route('admin.products.show',['product' => $product->id,'type' => 'invoices']) }}"><i class="bx bx-bell me-1"></i>
                        تفاصيل مشتريات الصنف
                    </a>
                </li>
            </ul>
            <div class="card">
                <h5 class="card-header">
                    تفاصيل مبيعات الصنف ( {{ $product->name }})
                </h5>
                <div class="card-header py-3">
                    <form id="filter-data" method="get" class="d-flex justify-content-between">
                        <div class="nav-item d-flex align-items-center m-2" style="background-color: #eee;padding: 8px;">
                            <i class="bx bx-search fs-4 lh-0"></i>
                            <input type="text" class="search form-control border-0 shadow-none" placeholder="البحث ...." @isset($search) value="{{ $search }}" @endisset id="search" name="search" style="background-color: #eee;"/>
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
                    <table class="table table-bordered">
                        <thead class="table-light">
                            @if(request('type') != 'invoices')
                                <tr style="background-color:#eee">
                                    <td colspan="3">
                                        اجمالى كمية المباعة من الصنف 
                                    </td>
                                    <td>
                                        {{ $product->order_items_sum_qty }} وحدة  / ك
                                    </td>
                                    <td colspan="2">
                                        اجمالى مبيعات الصنف 
                                    </td>
                                    <td>
                                        {{ formate_price($product->order_items_sum_order_itemsprice_order_itemsqty) }}
                                    </td>
                                </tr>
                            @else
                                <tr style="background-color:#eee">
                                    <td colspan="3">
                                        اجمالى كمية المشتريات من الصنف 
                                    </td>
                                    <td>
                                        {{ $product->invoice_items_sum_qty }} وحدة  / ك
                                    </td>
                                    <td colspan="2">
                                        اجمالى مشتريات الصنف 
                                    </td>
                                    <td>
                                        {{ formate_price($product->invoice_items_sum_invoice_itemsprice_invoice_itemsqty) }}
                                    </td>
                                </tr>
                            @endif
                            <tr class="table-dark">
                                <th>رقم الفاتورة</th>
                                <th>العميل</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>الاجمالى</th>
                                <th>تاريخ الفاتورة</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($order_items as $order_item)
                                @if(request('type') != 'invoices')
                                    <tr>
                                        <td>{{ $order_item->order->id }}</td>
                                        <td>{{ $order_item->order->customer->name }}</td>
                                        <td>{{ $order_item->qty }}</td>
                                        <td>{{ formate_price($order_item->price) }}</td>
                                        <td>{{ formate_price($order_item->price * $order_item->qty) }}</td>
                                        <td>{{ $order_item->created_at }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show',$order_item->order->id) }}">
                                                <i class="far fa-eye text-dark"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $order_item->purchasing_invoice ? $order_item->purchasing_invoice->id : '-' }}</td>
                                        <td>{{ $order_item->purchasing_invoice ? $order_item->purchasing_invoice->supplier->name : '-' }}</td>
                                        <td>{{ $order_item->qty }}</td>
                                        <td>{{ formate_price($order_item->price) }}</td>
                                        <td>{{ formate_price($order_item->price * $order_item->qty) }}</td>
                                        <td>{{ $order_item->created_at }}</td>
                                        <td>
                                            @if($order_item->purchasing_invoice)
                                                <a href="{{ route('admin.purchasing-invoices.show',$order_item->purchasing_invoice->id) }}">
                                                    <i class="far fa-eye text-dark"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex flex-row justify-content-center">
                    {{ $order_items->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection