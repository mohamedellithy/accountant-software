@extends('layouts.master')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">اضافة منتج جديد</h4>
        <!-- Basic Layout -->
        <form action="{{ route('admin.products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-xl" style="padding: 0px 10px 10px;text-align: left;">
                    <button type="submit" class="btn btn-success btn-sm">تعديل المنتج</button>
                </div>
                <br/>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">اسم المنتج</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="name" value="{{ $product->name }}" required/>
                                @error('name')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company "> نبذة عن المنتج </label>
                                <textarea id="basic-default-message" class="form-control"  rows="3" placeholder="" name='short_description' required>{{ $product->short_description }}</textarea>
                                @error('short_description')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company"> وصف المنتج</label>
                                <textarea id="basic-default-message" class="form-control summernote"  rows="10" placeholder="" name='description' required>{{ $product->description }}</textarea>
                                @error('description')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company">سعر المنتج</label>
                                <input id="basic-default-message" class="form-control" placeholder="" name='price' value="{{ $product->price }}" required>
                                @error('price')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company"> رابط المنتج</label>
                                <input id="basic-default-message" class="form-control" placeholder="" name='slug' value="{{ $product->slug }}" required>
                                @error('slug')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="mb-3">
                                <h4 class="">التحميلات </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">نوع الملف</label>
                                <select type="url" class="form-control download-type" id="basic-default-fullname" placeholder=""
                                    name="download_type" value="{{ old('download_type') }}" required>
                                    <option value="pdf"   @isset($product->downloads) @if($product->downloads->download_type == 'pdf') selected @endif   @endisset>Pdf</option>
                                    <option value="image" @isset($product->downloads) @if($product->downloads->download_type == 'image') selected @endif @endisset>Image</option>
                                    <option value="video" @isset($product->downloads) @if($product->downloads->download_type == 'video') selected @endif @endisset>Video</option>
                                    <option value="audio" @isset($product->downloads) @if($product->downloads->download_type == 'audio') selected @endif @endisset>Audio</option>
                                    <option value="zip"   @isset($product->downloads) @if($product->downloads->download_type == 'zip') selected @endif   @endisset>Zip</option>
                                    <option value="vnd.openxmlformats-officedocument.spreadsheetml.sheet"   @isset($product->downloads) @if($product->downloads->download_type == 'vnd.openxmlformats-officedocument.spreadsheetml.sheet') selected @endif   @endisset>xlsx</option>

                                </select>
                                @error('download_type')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="container-uploader">
                                    <button type="button" class="btn btn-info btn-sm download-files upload-media" data-type-media="pdf" data-multiple-media="true">
                                        <i class='bx bx-upload' ></i>
                                        اضافة ملفات قابلة للتحميل
                                        <input type="hidden" name="download_attachments_id" @isset($product->downloads) value="{{ $product->downloads->download_attachments_id  }}" @endisset
                                            class="form-control dob-picker uploaded-media-ids"/>
                                    </button>
                                    @error('download_attachments_id')
                                        <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                    @enderror
                                    <div class="preview-thumbs">
                                        <br/>
                                        <ul class="list-preview-thumbs">
                                            @isset($product->downloads)
                                                @if($product->downloads->download_attachments_id)
                                                    @foreach(GetAttachments($product->downloads->download_attachments_id) as $attachment)
                                                        <li class="preview-media-inner" title="{{ $attachment->name ?: fetchImageInnerDetails($attachment) }}">
                                                            @if(formateMediaType($attachment->type)[0] == 'video')
                                                                <video style="width:100%;height:100%" controls>
                                                                    <source src="{{ upload_assets($attachment) }}" type="{{ $attachment->type }}"></source>
                                                                </video>
                                                            @elseif(formateMediaType($attachment->type)[1] =='pdf')
                                                                <i style="font-size: 120px;" class='bx bxs-file-pdf'></i>
                                                            @elseif(formateMediaType($attachment->type)[0] == 'audio')
                                                                <audio style="width:100%;height:100%" controls>
                                                                    <source src="{{ upload_assets($attachment) }}" type="{{ $attachment->type }}"></source>
                                                                </audio>
                                                            @elseif(formateMediaType($attachment->type)[0] =='image')
                                                                <img src="{{ upload_assets($attachment) }}"/>
                                                            @else
                                                                <i style="font-size: 120px;" class='bx bxs-file-blank'></i>
                                                            @endif
                                                            <i class='bx bxs-message-square-x remove' media-id="{{ $attachment->id }}"></i>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            @endisset
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">حالة الملف</label>
                                <select type="url" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="download_status" value="{{ old('download_status') }}" required>
                                    <option value="download"         @isset($product->downloads) @if($product->downloads->download_status == 'download')  selected  @endif @endisset>تنزيل الملف او الفيديو</option>
                                    <option value="without_download" @isset($product->downloads) @if($product->downloads->download_status == 'without_download')  selected @endif @endisset>مشاهدة بدون تنزيل</option>
                                </select>
                                @error('download_status')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">رابط ملف التحميل ان وجدت</label>
                                <input type="url" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="download_link"  @isset($product->downloads) value="{{ $product->downloads->download_link ?: old('download_link') }}" @endisset>
                                @error('download_link')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">اسم الملف التحميلات</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="download_name" @isset($product->downloads) value="{{ $product->downloads->download_name ?: old('download_name') }}" @endisset required/>
                                @error('download_name')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">وصف ملف التحميلات</label>
                                <textarea type="text" class="form-control summernote" id="basic-default-fullname" placeholder=""
                                    name="download_description" required>{{  $product->downloads ? $product->downloads->download_description : old('download_description') }}</textarea>
                                @error('download_description')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="container-uploader">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" name="status" type="checkbox" id="flexSwitchCheckChecked" value="active" @if($product->status == 'active') checked @endif>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">حالة المنتج</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="container-uploader">
                                    <button type="button" class="btn btn-outline-warning btn-sm upload-media" data-type-media="image">
                                        <i class='bx bx-upload' ></i>
                                        اضافة صورة للمنتج
                                        <input type="hidden" name="thumbnail_id" value="{{ $product->thumbnail_id }}"
                                            class="form-control dob-picker uploaded-media-ids" required/>
                                    </button>
                                    @error('thumbnail_id')
                                        <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                    @enderror
                                    <div class="preview-thumbs">
                                        <br/>
                                        <ul class="list-preview-thumbs">
                                            @if($product->thumbnail_id)
                                                <li class="preview-media-inner">
                                                    <img src="{{ upload_assets($product->image_info) }}" />
                                                    <i class='bx bxs-message-square-x remove' media-id="{{ $product->thumbnail_id }}"></i>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="container-uploader">
                                    <button type="button" class="btn btn-outline-warning btn-sm upload-media" data-type-media="image" data-multiple-media="true">
                                        <i class='bx bx-upload' ></i>
                                        اضافة صور أخري  للمنتج
                                        <input type="hidden" name="attachments_id" value="{{ $product->attachments_id }}"
                                            class="form-control dob-picker uploaded-media-ids" required/>
                                    </button>
                                    @error('attachments_id')
                                        <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                    @enderror
                                    <div class="preview-thumbs">
                                        <br/>
                                        <ul class="list-preview-thumbs">
                                            @if($product->attachments_id)
                                                @foreach(GetAttachments($product->attachments_id) as $attachment)
                                                    <li class="preview-media-inner">
                                                        <img src="{{ upload_assets($attachment) }}" />
                                                        <i class='bx bxs-message-square-x remove' media-id="{{ $attachment->id }}"></i>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company">عنوان السيو ( meta title )</label>
                                <input type="text" id="basic-icon-default-company" class="form-control" name="meta_title"
                                    value="{{ old('meta_title') }}" />
                                @error('meta_title')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company">وصف السيو ( meta description ) </label>
                                <textarea type="text" id="basic-icon-default-company" class="form-control"
                                    name="meta_description">{{ old('meta_description') }}</textarea>
                                @error('meta_description')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- / Content -->
@endsection

@push('script')
<script>
    jQuery('document').ready(function(){
        jQuery('.download-type').on('change',function(){
           jQuery('.download-files').attr('data-type-media',jQuery(this).val());
        });
    });
</script>
@endpush
