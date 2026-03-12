<!-- Begin Page Content -->
@extends('Theme_2.layouts.master') @section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <br />
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link {{ IsActiveOnlyIf(['admin.suppliers.show']) }}" href="{{ route('admin.suppliers.show',$supplier->id) }}"><i class="bx bx-bell me-1"></i>
                        كشف حساب 
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link {{ IsActiveOnlyIf(['admin.supplier-payments-lists']) }}" href="{{ route('admin.customer-payments-lists',['id' => $supplier->id]) }}"><i
                            class="bx bx-link-alt me-1"></i> المدفوعات</a>
                </li>
            </ul>
            <div class="card">
                <form action="{{ route('admin.stake_holder.add-payments',['id' => $supplier->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <h5 class="card-header">تنزيل دفعات جديدة</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-md-5">
                                            <label class="form-label" for="basic-default-fullname">المبلغ</label>
                                            <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                                name="payment_value" value="{{ old('payment_value') }}" required />
                                            @error('name')
                                                <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-5">
                                            <label class="form-label" for="basic-default-fullname">العملية</label>
                                            <select class="form-control" name="type_payment">
                                                <option value="1">محصل من العميل قيمة مبيعات</option>
                                                <option value="2">مدفوع للعميل قيمة مشتريات</option>
                                                <option value="3">خصم من المتبقي على العميل او المورد</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-5">
                                            <label class="form-label" for="basic-default-fullname">ملاحظة</label>
                                            <textarea class="form-control" cols="1" rows="1" name="description" placeholder="ملاحظات عن الدفعة">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">تأكيد</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <hr/>
            <div class="card">
                <h5 class="card-header">
                    مدفوعات العميل {{ $supplier->name }}
                </h5>
                <div class="table-responsive">
                    <table class="table table-border">
                        <thead class="table-light">
                            <tr class="table-dark">
                                <th>تاريخ العملية</th>
                                <th>قيمة الدفعة</th>
                                <th>نوع العملية</th>
                                <th>رقم الفاتورة</th>
                                <th>ملاحظة</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>
                                        {{ $payment->created_at }}
                                    </td>
                                    <td>
                                        {{ formate_price($payment->value) }}
                                    </td>
                                    <td>
                                        @if($payment->model_type  == 'for_sales')
                                            محصل من العميل قيمة مبيعات
                                        @elseif($payment->model_type  == 'for_purchasing')
                                            مدفوع للعميل قيمة مشتريات
                                        @elseif($payment->model_type  == 'for_discounts')
                                            خصم من المتبقي على العميل او المورد
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($payment->invoice_id))
                                            {{ ' # '.$payment->invoice_id }}
                                        @else
                                             غير مرفق فاتورة
                                        @endif
                                    </td>
                                    <td>
                                        {{ $payment?->description ?: '-' }}
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="crud edit-payment" data-payment-type="{{ $payment->model_type }}" data-payment-id="{{ $payment->id }}">
                                                <i class="fas fa-edit text-primary"></i>
                                            </a>
                                            @if($payment->model_type  == 'for_sales')
                                                <form  method="post" action="{{ route('admin.customer-payment.destroy', $payment->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="delete-item crud" data-payment-name="{{ $payment->id }}">
                                                        <i class="fas fa-trash-alt  text-danger"></i>
                                                    </a>
                                                </form>
                                            @elseif($payment->model_type  == 'for_purchasing')
                                                <form  method="post" action="{{ route('admin.supplier-payment.destroy', $payment->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="delete-item crud" data-payment-name="{{ $payment->value }}">
                                                        <i class="fas fa-trash-alt  text-danger"></i>
                                                    </a>
                                                </form>
                                            @elseif($payment->model_type  == 'for_discounts')
                                                <form  method="post" action="{{ route('admin.user-discounts.destroy', $payment->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="delete-item crud" data-payment-name="{{ $payment->value }}">
                                                        <i class="fas fa-trash-alt  text-danger"></i>
                                                    </a>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex flex-row justify-content-center">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection


@push('script')
<script>
   jQuery('.edit-payment').click(function(){
       let data_edit = jQuery(this).attr('data-payment-id');
       let payment_type = jQuery(this).attr('data-payment-type');
       let Popup = jQuery('#modalCenter').modal('show');
       let url   = "";
       if(payment_type == 'for_purchasing'){
           url = "{{ route('admin.supplier-payment.edit',':id') }}";
       } else if(payment_type == 'for_sales') {
           url = "{{ route('admin.customer-payment.edit',':id') }}";
       } else if(payment_type == 'for_discounts') {
           url = "{{ route('admin.user-discounts.edit',':id') }}";
       }

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
       let customer_name = jQuery(this).attr('data-payment-name');
       if(confirm('هل متأكد من اتمام حذف المدفوعات قيمة #'+ customer_name)){
           jQuery(this).parents('form').submit();
       }
   });
</script>
@endpush