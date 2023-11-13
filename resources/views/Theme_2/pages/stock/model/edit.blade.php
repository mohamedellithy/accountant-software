<h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">تعديل الصنف </h4>
<!-- Basic Layout -->
<form action="{{ route('admin.stocks.update', $stock->id) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="mb-3 col-md-12">
            <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-country">
                اسم الصنف</label>
            <select name="product_id" class="form-select2 form-control"
                data-allow-clear="true" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" @if($stock->product->id == $product->id) selected @endif>{{ $product->name }}</option>
                @endforeach
            </select>
            @error('product_id')
                <span class="text-danger w-100 fs-6">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 col-md-12">
            <label class="form-label" for="basic-default-company"> الكمية</label>
            <input type="number" class="form-control" id="basic-default-fullname" placeholder="" step=".01"
                name="quantity"  value="{{ $stock->quantity ?: old('quantity') }}" required/>
            @error('quantity')
                <span class="text-danger w-100 fs-6">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 col-md-12">
            <label class="form-label" for="basic-default-company"> سعر الشراء ( الوحدة / الكيلو ) </label>
            <input type="number" step="0.1" class="form-control" id="basic-default-fullname" placeholder=""
                name="purchasing_price" value="{{ $stock->purchasing_price ?: old('purchasing_price') }}" required />
            @error('purchasing_price')
                <span class="text-danger w-100 fs-6">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 col-md-12">
            <label class="form-label" for="basic-default-company"> سعر البيع ( الوحدة / الكيلو ) </label>
            <input type="number" step="0.1" class="form-control" id="basic-default-fullname" placeholder=""
                name="sale_price" value="{{ $stock->sale_price ?: old('sale_price') }}" required />
            @error('sale_price')
                <span class="text-danger w-100 fs-6">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3 col-md-12">
            <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-country">
                اسم المورد</label>
            <select name="supplier_id" id="formtabs-country" class="form-select2 form-control"
                data-allow-clear="true" required>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" @if($stock->supplier->id == $supplier->id) selected @endif>{{ $supplier->name }}</option>
                @endforeach
            </select>
            @error('supplier_id')
                <span class="text-danger w-100 fs-6">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
            الغاء
        </button>
        <button type="submit" class="btn btn-primary btn-sm">تحديث صنف</button>
    </div>
</form>



