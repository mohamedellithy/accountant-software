@extends('layouts.master')

@php
$settings = platformSettings();
@endphp
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">
           اعدادات بوابات الدفع
        </h4>
        <!-- Basic Layout -->
        <form action="{{ route('admin.settings.payments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="mb-3">
                                <h4 for="basic-default-fullname">ثوانى ( Thawani )</h4>
                                <input type="hidden" name="payments[]" value="thawani"/>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" name="thawani_enable" type="checkbox" id="flexSwitchCheckChecked" value="active" checked>
                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-default-fullname"> مسمى البوابة</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="thawani_title" value="{{ isset($settings['thawani_title']) ? $settings['thawani_title'] : old('thawani_title') }}"/>
                                @error('thawani_title')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-default-fullname"> المفتاح ( Thawani API key )</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="thawani_api_key" value="{{ isset($settings['thawani_api_key']) ? $settings['thawani_api_key'] : old('thawani_api_key') }}"/>
                                @error('thawani_api_key')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-default-fullname">المفتاح العام ( Thawani public key )</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="thawani_public_key" value="{{ isset($settings['thawani_public_key']) ? $settings['thawani_public_key'] : old('thawani_public_key') }}"/>
                                @error('thawani_public_key')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <div class="container-uploader">
                                    <button type="button" class="btn btn-info btn-sm upload-media" data-type-media="image">
                                        <i class='bx bx-upload' ></i>
                                        لوجو لبوابة الدفع
                                        <input type="hidden" name="thawani_logo" value="{{ isset($settings['thawani_logo']) ? $settings['thawani_logo'] : ''  }}"
                                            class="form-control dob-picker uploaded-media-ids"/>
                                    </button>
                                    @error('thawani_logo')
                                        <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                    @enderror
                                    <div class="preview-thumbs">
                                        <br/>
                                        <ul class="list-preview-thumbs">
                                            @if(isset($settings['thawani_logo']))
                                                <li class="preview-media-inner">
                                                    <img src="{{ upload_assets(ImageInfo($settings['thawani_logo'])) }}" />
                                                    <i class='bx bxs-message-square-x remove' media-id="{{ $settings['thawani_logo'] }}"></i>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">
                        حفظ الاعدادات
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- / Content -->
@endsection
