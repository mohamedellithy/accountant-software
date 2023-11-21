<h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">تعديل الدفعة </h4>
<!-- Basic Layout -->
@if(class_basename($payment) == 'CustomerPayment')
<form action="{{ route('admin.customer-payment.update',['payment_id' => $payment->id]) }}" method="POST" enctype="multipart/form-data">
@else
<form action="{{ route('admin.supplier-payment.update',['payment_id' => $payment->id]) }}" method="POST" enctype="multipart/form-data">
@endif
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="basic-default-fullname">المبلغ</label>
                        <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                            name="value" value="{{ $payment->value }}" required />
                        @error('value')
                            <span class="text-danger w-100 fs-6">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
            الغاء
        </button>
        <button type="submit" class="btn btn-primary btn-sm">تحديث الدفعة</button>
    </div>
</form>



