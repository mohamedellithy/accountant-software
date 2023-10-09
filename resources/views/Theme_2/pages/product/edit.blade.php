@extends('Theme_2.layouts.master')

@section('content')
    <div class="container-fluid">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">تعديل الصنف </h4>
        <!-- Basic Layout -->
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">اسم الصنف</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="name" value="{{ $product->name }}" required />
                                @error('name')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">تحديث صنف</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
