@extends('layouts.master')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">
            {{ $product->name }}
        </h4>
        <!-- Basic Layout -->
            <div class="row">
                <div class="col-xl" style="padding: 0px 10px 10px;text-align: left;">
                    <a href="{{ route('admin.products.edit',$product->id) }}" class="btn btn-success btn-sm">تعديل المنتج</a>
                </div>
                <br/>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname" style="color: orange;">اسم المنتج</label>
                                <h5 style="line-height: 1.8em;">{{ $product->name }}</h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company" style="color: orange;"> وصف المنتج</label>
                                <h6 style="line-height: 1.8em;">{{ $product->description }}</h6>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company" style="color: orange;">سعر المنتج</label>
                                <h5 style="line-height: 1.8em;">{{ formate_price($product->price) }}</h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company" style="color: orange;">عنوان السيو ( meta title )</label>
                                <h5 style="line-height: 1.8em;">{{ $product->meta_title ?: 'غير متوفر' }}</h5>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company" style="color: orange;">وصف السيو ( meta description ) </label>
                                <h5 style="line-height: 1.8em;">{{ $product->meta_description ?: 'غير متوفر' }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="container-uploader">
                                    <div class="preview-thumbs">
                                        <ul class="list-preview-thumbs">
                                            @if($product->thumbnail_id)
                                                <li class="preview-media-inner" style="border: 10px solid gray;">
                                                    <img src="{{ upload_assets($product->image_info) }}" />
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="container-uploader">
                                    <div class="preview-thumbs">
                                        <h6 style="color: orange;"> باقي صور المنتج</h6>
                                        <ul class="list-preview-thumbs">
                                            @if($product->attachments_id)
                                                @foreach(GetAttachments($product->attachments_id) as $attachment)
                                                    <li class="preview-media-inner">
                                                        <img src="{{ upload_assets($attachment) }}" />
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- / Content -->
@endsection
