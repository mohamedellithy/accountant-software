@extends('Theme_2.layouts.master')
@php
$search = request()->query('search') ?: null;
$rows = request()->query('rows') ?: 10;
$filter = request()->query('filter') ?: null;
@endphp @section('content')
<div class="container-fluid">
   <br/>
   <!-- Basic Layout -->
   <form action="{{ route('admin.suppliers.store') }}" method="POST" enctype="multipart/form-data">
       @csrf
       <div class="row">
           <div class="col-lg-12">
               <div class="card mb-4">
                   <h5 class="card-header">اضافة مورد جديد</h5>
                   <div class="card-body">
                       <div class="row">
                           <div class="mb-3 col-md-4">
                               <label class="form-label" for="basic-default-fullname">اسم المورد</label>
                               <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                   name="name" value="{{ old('name') }}" required />
                               @error('name')
                                   <span class="text-danger w-100 fs-6">{{ $message }}</span>
                               @enderror
                           </div>
                           <div class="mb-3 col-md-4">
                               <label class="form-label" for="basic-default-company"> رقم التليفون</label>
                               <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                   name="phone" value="{{ old('phone') }}" required />
                               @error('phone')
                                   <span class="text-danger w-100 fs-6">{{ $message }}</span>
                               @enderror
                           </div>
                           <div class="mb-3 col-md-4">
                                <label class="form-label" for="basic-default-company"> رصيد مبدأي</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="balance" value="{{ old('balance') }}" required />
                                @error('balance')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                       </div>
                       <button type="submit" class="btn btn-primary">اضافة مورد جديد</button>
                   </div>
               </div>
           </div>
       </div>
   </form>
</div>
<div class="container-fluid">
   <!-- DataTales Example -->
   <div class="card mb-4">
       <div class="card">
           <h5 class="card-header">عرض الموردين</h5>
           <div class="card-header py-3 ">
               <form id="filter-data" method="get" class="d-flex justify-content-between">
                   <div class="mb-3 col-md-4">
                        <label class="form-label"  for="formtabs-country">اسم المورد</label>
                        <select name="filter[supplier_id]" id="formtabs-country" onchange="document.getElementById('filter-data').submit()" class="form-select2 form-control"
                            data-allow-clear="true">
                            <option value="">الكل</option>
                            @foreach($suppliers_all as $supplier)
                                <option value={{ $supplier->id }} @isset($filter['supplier_id']) @if ($filter['supplier_id'] == $supplier->id) selected @endif
                                    @endisset>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
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
           <div class="table-responsive">
               <table class="table">
                   <thead class="table-light">
                       <tr class="table-dark">
                            <th>كود العميل</th>
                            <th>اسم العميل</th>
                            <th>رقم الهاتف</th>
                            <th>الرصيد البدائي</th>
                            <th>اجمالى الطلبات</th>
                            <th>اجمالى التعاملات</th>
                            <th></th>
                       </tr>
                   </thead>
                   <tbody class="table-border-bottom-0">
                       @foreach($suppliers as $supplier)
                           <tr class="table-light">
                               <td>{{ $supplier->id }}</td>
                               <td>{{ $supplier->name }}</td>
                               <td>{{ $supplier->phone }}</td>
                               <td>{{ formate_price($supplier->balance) }}</td>
                               <td>
                                    {{ $supplier->orders_count + $supplier->purchasing_invoices_count }} طلبية
                                    <a class="crud" href="{{ route('admin.orders.show', $supplier->id) }}">
                                        <i class="far fa-eye"></i>
                                    </a>
                               </td>
                               <td>
                                   {{ formate_price($supplier->orders_sum_total_price + $supplier->purchasing_invoices_sum_total_price) }}
                               </td>
                               <td>
                                   <div class="d-flex">
                                        <a class="crud" href="{{ route('admin.suppliers.show', $supplier->id) }}">
                                            <i class="far fa-eye text-dark"></i>
                                        </a>
                                       <a class="crud edit-supplier" data-supplier-id="{{ $supplier->id }}">
                                           <i class="fas fa-edit text-primary"></i>
                                       </a>
                                       <form  method="post" action="{{ route('admin.suppliers.destroy', $supplier->id) }}">
                                           @csrf
                                           @method('DELETE')
                                           <a class="delete-item crud" data-supplier-id="{{ $supplier->id }}">
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
               {{ $suppliers->links() }}
           </div>
       </div>
   </div>
</div>
@endsection

@push('script')
<script>
   jQuery('.edit-supplier').click(function(){
       let data_edit = jQuery(this).attr('data-supplier-id');
       let Popup = jQuery('#modalCenter').modal('show');
       let url = "{{ route('admin.suppliers.edit',':id') }}";
       url = url.replace(':id',data_edit);
       $.ajax({
           url:url,
           type:"GET",
           success: function(data){
               if(data.status == true){
                   jQuery('#modal-content-inner').html(data.view);
               }
               console.log(data);
           }
       })
       console.log(Popup);
   });

   jQuery('.delete-item').click(function(){
       let customer_name = jQuery(this).attr('data-supplier-name');
       if(confirm('هل متأكد من اتمام حذف المورد  '+ customer_name)){
           jQuery(this).parents('form').submit();
       }
   });
</script>
@endpush
