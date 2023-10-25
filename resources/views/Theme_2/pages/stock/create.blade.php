@extends('Theme_2.layouts.master')

@section('content')
    <div class="container-fluid">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">اضافة صنف جديد</h4>
        <!-- Basic Layout -->
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">اسم الصنف</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="name" value="{{ old('name') }}" required />
                                @error('name')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company"> الكمية</label>
                                <input type="number" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="quantity" value="{{ old('quantity') }}" required />
                                @error('quantity')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company"> السعر</label>
                                <input type="number" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="price" value="{{ old('price') }}" required />
                                @error('price')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-country">

                                    اسم المورد</label>
                                <select name="supplier_id" id="formtabs-country" class="form-control"
                                    data-allow-clear="true" required>
                                    @foreach ($suppliers as $supplier)
                                        <option value={{ $supplier->id }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">اضافة صنف</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('style')
<style>
    @media(max-width:1000px){
        table tr {
            display: grid;
        }
        table tr.dynamic-added td .mb-3{
            margin-bottom: 0px !important;
        }
    }
</style>
@endpush