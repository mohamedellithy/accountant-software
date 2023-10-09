@extends('layouts.master')

@php
$settings = platformSettings();
@endphp
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">
           اعدادات المنصة
        </h4>
        <!-- Basic Layout -->
        <form action="{{ route('admin.settings.general.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="mb-3">
                                <h5 for="basic-default-fullname">اعدادات عامة</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-default-fullname">اسم المنصة</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="website_name" value="{{ $settings['website_name'] ?: old('website_name') }}"/>
                                @error('website_name')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-default-fullname">البريد الالكتروني</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="admin_email" value="{{ $settings['admin_email'] ?: old('admin_email') }}"/>
                                @error('admin_email')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-default-fullname">العنوان</label>
                                <textarea type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="website_address">{{ isset($settings['website_address']) ? $settings['website_address'] : old('website_address') }}
                                </textarea>
                                @error('website_address')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-default-fullname">رقم الواتس </label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="website_whastapp" value="{{ $settings['website_whastapp'] ?: old('website_whastapp') }}"/>
                                @error('website_whastapp')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <div class="container-uploader">
                                    <button type="button" class="btn btn-warning btn-sm upload-media" data-type-media="image">
                                        <i class='bx bx-upload' ></i>
                                        اضافة لوجو الموقع
                                        <input type="hidden" name="website_logo" value="{{ isset($settings['website_logo']) ? $settings['website_logo'] : ''  }}"
                                            class="form-control dob-picker uploaded-media-ids"/>
                                    </button>
                                    @error('website_logo')
                                        <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                    @enderror
                                    <div class="preview-thumbs">
                                        <br/>
                                        <ul class="list-preview-thumbs">
                                            @if(isset($settings['website_logo']))
                                                <li class="preview-media-inner">
                                                    <img src="{{ upload_assets(ImageInfo($settings['website_logo'])) }}" />
                                                    <i class='bx bxs-message-square-x remove' media-id="{{ $settings['website_logo'] }}"></i>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="mb-3">
                                <h5 for="basic-default-fullname">اعدادات المدفوعات</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="form-label d-flex" for="basic-default-fullname">
                                   عملة المنصة
                                </label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="website_currency" value="{{ $settings['website_currency'] ?: old('website_currency') }}"/>
                                @error('title')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="mb-3">
                                <h5 for="basic-default-fullname">تفعيل الاقسام</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <div class="form-check form-switch mb-2" style="float: right;">
                                    <input class="form-check-input" name="reviews_enable" type="checkbox" id="flexSwitchCheckChecked" value="active" @if(isset($settings['reviews_enable']) && $settings['reviews_enable'] == 'active') checked @endif>
                                    <label class="form-check-label" style=" float: left;" for="flexSwitchCheckChecked">تفعيل قسم التقيمات</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="mb-3">
                                <h5 for="basic-default-fullname">اعدادات روابط السوشيال ميديا</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="form-label d-flex" for="basic-default-fullname">
                                    <i class="bx bxl-facebook-circle mx-1"></i>
                                    الفيس بوك
                                </label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="social_facebook" value="{{ $settings['social_facebook'] ?: old('social_facebook') }}"/>
                                @error('social_facebook')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label d-flex" for="basic-default-fullname">
                                    <i class='bx bxl-twitter mx-1'></i>
                                    تويتر
                                </label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="social_twitter" value="{{ $settings['social_twitter'] ?: old('social_twitter') }}"/>
                                @error('social_twitter')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label d-flex" for="basic-default-fullname">
                                    <i class='bx bxl-instagram-alt mx-1' ></i>
                                    انستجرام
                                </label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="social_insta" value="{{ $settings['social_insta'] ?: old('social_insta') }}"/>
                                @error('social_insta')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label d-flex" for="basic-default-fullname">
                                    <i class='bx bxl-linkedin-square mx-1'></i>
                                    لينكدان
                                </label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="website_linkedin" value="{{ $settings['website_linkedin'] ?: old('website_linkedin') }}"/>
                                @error('website_linkedin')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label d-flex" for="basic-default-fullname">
                                    <i class='bx bxl-youtube mx-1' ></i>
                                    يوتيوب
                                </label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="social_youtube" value="{{ $settings['social_youtube'] ?: old('social_youtube') }}"/>
                                @error('social_youtube')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="mb-3">
                                <h5 for="basic-default-fullname">اعدادات السيو</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company">عنوان السيو ( meta title )</label>
                                <input type="text" id="basic-icon-default-company" class="form-control" name="meta_title"
                                    value="{{ isset($settings['meta_title']) ? $settings['meta_title'] : old('meta_title') }}" />
                                @error('meta_title')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company">وصف السيو ( meta description ) </label>
                                <textarea type="text" id="basic-icon-default-company" class="form-control"
                                    name="meta_description">{{ isset($settings['meta_description']) ? $settings['meta_description'] : old('meta_description') }}</textarea>
                                @error('meta_description')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="mb-3">
                                <h5 for="basic-default-fullname">اضافة خريطة </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="form-label d-flex" for="basic-default-fullname">
                                   خريطة
                                </label>
                                <textarea type="text" class="form-control" rows="10" id="basic-default-fullname" placeholder=""
                                    name="website_location_map" >{{ isset($settings['website_location_map']) ? $settings['website_location_map'] : old('website_location_map') }}"</textarea>
                                @error('title')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">
                        اضافة صفحة جديدة
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- / Content -->
@endsection
