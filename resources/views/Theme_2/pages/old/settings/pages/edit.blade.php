@extends('layouts.master')
@php
// dd($page->content)
@endphp
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;"> {{ $page->title  }}</h4>
        <!-- Basic Layout -->
        <form action="{{ route('admin.settings.pages.update',$page->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-xl" style="padding: 0px 10px 10px;text-align: left;">
                    <button type="submit" class="btn btn-success btn-sm">تعديل الصفحة</button>
                </div>
                <br/>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">اسم الصفحة</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="title" value="{{ $page->title }}" required/>
                                @error('title')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company"> رابط الصفحة</label>
                                <input id="basic-default-message" class="form-control" placeholder="" name='slug' value="{{ $page->slug }}"  @if(!IsNotAllowPagesChangeSlug($page->slug)) disabled readonly @endif required>
                                @error('slug')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @if($page->slug == '/')
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- Slider Bannerr -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> السلايدر الامامى</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" name="content[slider_banner][enable]" type="checkbox" id="flexSwitchCheckChecked" value="active" @if(isset($page->content['slider_banner']['enable']) && $page->content['slider_banner']['enable'] == 'active') checked @endif>
                                    <label class="form-check-label" style=" float: left;" for="flexSwitchCheckChecked">عرض القسم</label>
                                </div>
                                <div class="settings-page" style="cursor: pointer">
                                    <a class="btn btn-warning btn-sm" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        اعدادات القسم
                                    </a>
                                    <div class="collapse" id="collapseExample">
                                        <div class="card card-body">
                                            <div class="mb-3">
                                                <label>عنوان رئيسي</label>
                                                <input name="content[slider_banner][heading]" @isset($page->content['slider_banner']['heading']) value="{{ $page->content['slider_banner']['heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>عنوان فرعي</label>
                                                <input name="content[slider_banner][sub_heading]" @isset($page->content['slider_banner']['sub_heading']) value="{{ $page->content['slider_banner']['sub_heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>نص وصفي</label>
                                                <textarea name="content[slider_banner][description]" class="form-control">@isset($page->content['slider_banner']['description']) {{ $page->content['slider_banner']['description'] }} @endisset</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <div class="container-uploader">
                                                    <button type="button" class="btn btn-outline-warning btn-sm upload-media" data-type-media="image">
                                                        <i class='bx bx-upload' ></i>
                                                        اضافة صورة
                                                       <input type="hidden" name="content[slider_banner][thumbnail_id]" @isset($page->content['slider_banner']['thumbnail_id']) value="{{ $page->content['slider_banner']['thumbnail_id'] }}" @endisset
                                                            class="form-control dob-picker uploaded-media-ids" required/>
                                                    </button>
                                                    <div class="preview-thumbs">
                                                        <br/>
                                                        <ul class="list-preview-thumbs">
                                                            @isset($page->content['slider_banner']['thumbnail_id'])
                                                                @include('partials.media_preview_list',['media_id' => $page->content['slider_banner']['thumbnail_id']])
                                                            @endisset
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label> رابط الفيديو ( يويتيوب )</label>
                                                <input name="content[slider_banner][video_link]" @isset($page->content['slider_banner']['video_link']) value="{{ $page->content['slider_banner']['video_link'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label> أو </label>
                                            </div>
                                            <div class="mb-3">
                                                <div class="container-uploader">
                                                    <button type="button" class="btn btn-outline-warning btn-sm upload-media" data-type-media="video">
                                                        <i class='bx bx-upload' ></i>
                                                        اضافة فيديو
                                                       <input type="hidden" name="content[slider_banner][video_id]" @isset($page->content['slider_banner']['video_id']) value="{{ $page->content['slider_banner']['video_id'] }}" @endisset
                                                            class="form-control dob-picker uploaded-media-ids" required/>
                                                    </button>
                                                    <div class="preview-thumbs">
                                                        <br/>
                                                        <ul class="list-preview-thumbs">
                                                            @isset($page->content['slider_banner']['video_id'])
                                                                @include('partials.media_preview_list',['media_id' => $page->content['slider_banner']['video_id']])
                                                            @endisset
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- partner Bannerr -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> وكلائنا</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" name="content[partner_banner][enable]" type="checkbox" id="flexSwitchCheckChecked" value="active" @if(isset($page->content['partner_banner']['enable']) && $page->content['partner_banner']['enable'] == 'active') checked @endif>
                                    <label class="form-check-label" style=" float: left;" for="flexSwitchCheckChecked">عرض القسم</label>
                                </div>
                                <div class="settings-page" style="cursor: pointer">
                                    <a class="btn btn-warning btn-sm" data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        اعدادات القسم
                                    </a>
                                    <div class="collapse" id="collapseExample2">
                                        <div class="card card-body">
                                            <div class="mb-3">
                                                <label>عنوان فرعي</label>
                                                <input name="content[partner_banner][sub_heading]" @isset($page->content['partner_banner']['sub_heading']) value="{{ $page->content['partner_banner']['sub_heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <div class="container-uploader">
                                                    <button type="button" class="btn btn-outline-warning btn-sm upload-media" data-type-media="image" data-multiple-media="true">
                                                        <i class='bx bx-upload' ></i>
                                                        اضافة صورة
                                                       <input type="hidden" name="content[partner_banner][thumbnails_id]" @isset($page->content['partner_banner']['thumbnails_id']) value="{{ $page->content['partner_banner']['thumbnails_id'] }}" @endisset
                                                            class="form-control dob-picker uploaded-media-ids"/>
                                                    </button>
                                                    <div class="preview-thumbs">
                                                        <br/>
                                                        <ul class="list-preview-thumbs">
                                                            @isset($page->content['partner_banner']['thumbnails_id'])
                                                                @foreach(GetAttachments($page->content['partner_banner']['thumbnails_id']) as $attachment)
                                                                    @include('partials.media_preview_list',['media_id' => $attachment->id ,'media' => $attachment])
                                                                @endforeach
                                                            @endisset
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- about-us Bannerr -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> من نحن</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" name="content[about_banner][enable]" type="checkbox" id="flexSwitchCheckChecked" value="active" @if(isset($page->content['about_banner']['enable']) && $page->content['about_banner']['enable'] == 'active') checked @endif>
                                    <label class="form-check-label" style=" float: left;" for="flexSwitchCheckChecked">عرض القسم</label>
                                </div>
                                <div class="settings-page" style="cursor: pointer">
                                    <a class="btn btn-warning btn-sm" data-bs-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        اعدادات القسم
                                    </a>
                                    <div class="collapse" id="collapseExample3">
                                        <div class="card card-body">
                                            <div class="mb-3">
                                                <label>عنوان رئيسي</label>
                                                <input name="content[about_banner][heading]" @isset($page->content['about_banner']['heading']) value="{{ $page->content['about_banner']['heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>عنوان فرعي</label>
                                                <input name="content[about_banner][sub_heading]" @isset($page->content['about_banner']['sub_heading']) value="{{ $page->content['about_banner']['sub_heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>عدد سنين الخبرة</label>
                                                <input name="content[about_banner][expereince_years]" @isset($page->content['about_banner']['expereince_years']) value="{{ $page->content['about_banner']['expereince_years'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>وصف الخبرة</label>
                                                <input name="content[about_banner][expereince_description]" @isset($page->content['about_banner']['expereince_description']) value="{{ $page->content['about_banner']['expereince_description'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>نص وصفي</label>
                                                <textarea name="content[about_banner][description]" class="form-control summernote">@isset($page->content['about_banner']['description']) {{ $page->content['about_banner']['description'] }} @endisset</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <div class="container-uploader">
                                                    <button type="button" class="btn btn-outline-warning btn-sm upload-media" data-type-media="image">
                                                        <i class='bx bx-upload' ></i>
                                                         اضافة صورة رئيسية
                                                       <input type="hidden" name="content[about_banner][thumbnail_id_big]" @isset($page->content['about_banner']['thumbnail_id_big']) value="{{ $page->content['about_banner']['thumbnail_id_big'] }}" @endisset
                                                            class="form-control dob-picker uploaded-media-ids" required/>
                                                    </button>
                                                    <div class="preview-thumbs">
                                                        <br/>
                                                        <ul class="list-preview-thumbs">
                                                            @isset($page->content['about_banner']['thumbnail_id_big'])
                                                                @include('partials.media_preview_list',['media_id' => $page->content['about_banner']['thumbnail_id_big']])
                                                            @endisset
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="container-uploader">
                                                    <button type="button" class="btn btn-outline-warning btn-sm upload-media" data-type-media="image">
                                                        <i class='bx bx-upload' ></i>
                                                        اضافة صورة فرعية
                                                       <input type="hidden" name="content[about_banner][thumbnail_id_small]" @isset($page->content['about_banner']['thumbnail_id_small']) value="{{ $page->content['about_banner']['thumbnail_id_small'] }}" @endisset
                                                            class="form-control dob-picker uploaded-media-ids" required/>
                                                    </button>
                                                    <div class="preview-thumbs">
                                                        <br/>
                                                        <ul class="list-preview-thumbs">
                                                            @isset($page->content['about_banner']['thumbnail_id_small'])
                                                                @include('partials.media_preview_list',['media_id' => $page->content['about_banner']['thumbnail_id_small']])
                                                            @endisset
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="container-uploader">
                                                    <button type="button" class="btn btn-outline-warning btn-sm upload-media" data-type-media="image">
                                                        <i class='bx bx-upload' ></i>
                                                         اضافة صورة المدير
                                                       <input type="hidden" name="content[about_banner][thumbnail_ceo_id]" @isset($page->content['about_banner']['thumbnail_ceo_id']) value="{{ $page->content['about_banner']['thumbnail_ceo_id'] }}" @endisset
                                                            class="form-control dob-picker uploaded-media-ids" required/>
                                                    </button>
                                                    <div class="preview-thumbs">
                                                        <br/>
                                                        <ul class="list-preview-thumbs">
                                                            @isset($page->content['about_banner']['thumbnail_ceo_id'])
                                                                @include('partials.media_preview_list',['media_id' => $page->content['about_banner']['thumbnail_ceo_id']])
                                                            @endisset
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="container-uploader">
                                                    <button type="button" class="btn btn-outline-warning btn-sm upload-media" data-type-media="image">
                                                        <i class='bx bx-upload' ></i>
                                                         اضافة صورة التوقيع
                                                       <input type="hidden" name="content[about_banner][thumbnail_signature_id]" @isset($page->content['about_banner']['thumbnail_signature_id']) value="{{ $page->content['about_banner']['thumbnail_signature_id'] }}" @endisset
                                                            class="form-control dob-picker uploaded-media-ids" required/>
                                                    </button>
                                                    <div class="preview-thumbs">
                                                        <br/>
                                                        <ul class="list-preview-thumbs">
                                                            @isset($page->content['about_banner']['thumbnail_signature_id'])
                                                                @include('partials.media_preview_list',['media_id' => $page->content['about_banner']['thumbnail_signature_id']])
                                                            @endisset
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label>اسم المدير</label>
                                                <input name="content[about_banner][ceo_name]" @isset($page->content['about_banner']['ceo_name']) value="{{ $page->content['about_banner']['ceo_name'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>المنصب الوظيفي</label>
                                                <input name="content[about_banner][ceo_position]" @isset($page->content['about_banner']['ceo_position']) value="{{ $page->content['about_banner']['ceo_position'] }}" @endisset  class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- services Bannerr -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> خدماتنا</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" name="content[services_banner][enable]" type="checkbox" id="flexSwitchCheckChecked" value="active" @if(isset($page->content['services_banner']['enable']) && $page->content['services_banner']['enable'] == 'active') checked @endif>
                                    <label class="form-check-label" style=" float: left;" for="flexSwitchCheckChecked">عرض القسم</label>
                                </div>
                                <div class="settings-page" style="cursor: pointer">
                                    <a class="btn btn-warning btn-sm" data-bs-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        اعدادات القسم
                                    </a>
                                    <div class="collapse" id="collapseExample4">
                                        <div class="card card-body">
                                            <div class="mb-3">
                                                <label>عنوان رئيسي</label>
                                                <input name="content[services_banner][heading]" @isset($page->content['services_banner']['heading']) value="{{ $page->content['services_banner']['heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>عنوان فرعي</label>
                                                <input name="content[services_banner][sub_heading]" @isset($page->content['services_banner']['sub_heading']) value="{{ $page->content['services_banner']['sub_heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>نص وصفي</label>
                                                <textarea name="content[services_banner][description]" class="form-control">@isset($page->content['services_banner']['description']) {{ $page->content['services_banner']['description'] }} @endisset</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- introduce Bannerr -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> ماذا تقدم</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" name="content[introduce_banner][enable]" type="checkbox" id="flexSwitchCheckChecked" value="active" @if(isset($page->content['introduce_banner']['enable']) && $page->content['introduce_banner']['enable'] == 'active') checked @endif>
                                    <label class="form-check-label" style=" float: left;" for="flexSwitchCheckChecked">عرض القسم</label>
                                </div>
                                <div class="settings-page" style="cursor: pointer">
                                    <a class="btn btn-warning btn-sm" data-bs-toggle="collapse" href="#collapseExample5" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        اعدادات القسم
                                    </a>
                                    <div class="collapse" id="collapseExample5">
                                        <div class="card card-body">
                                            <div class="mb-3">
                                                <label>عنوان رئيسي</label>
                                                <input name="content[introduce_banner][heading]" @isset($page->content['introduce_banner']['heading']) value="{{ $page->content['introduce_banner']['heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>عنوان فرعي</label>
                                                <input name="content[introduce_banner][sub_heading]" @isset($page->content['introduce_banner']['sub_heading']) value="{{ $page->content['introduce_banner']['sub_heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>نص وصفي</label>
                                                <textarea name="content[introduce_banner][description]" class="form-control summernote">@isset($page->content['introduce_banner']['description']) {{ $page->content['introduce_banner']['description'] }} @endisset</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <div class="container-uploader">
                                                    <button type="button" class="btn btn-outline-warning btn-sm upload-media" data-type-media="image">
                                                        <i class='bx bx-upload' ></i>
                                                        اضافة صورة
                                                       <input type="hidden" name="content[introduce_banner][thumbnail_id]" @isset($page->content['introduce_banner']['thumbnail_id']) value="{{ $page->content['introduce_banner']['thumbnail_id'] }}" @endisset
                                                            class="form-control dob-picker uploaded-media-ids" required/>
                                                    </button>
                                                    <div class="preview-thumbs">
                                                        <br/>
                                                        <ul class="list-preview-thumbs">
                                                            @isset($page->content['introduce_banner']['thumbnail_id'])
                                                                @include('partials.media_preview_list',['media_id' => $page->content['introduce_banner']['thumbnail_id']])
                                                            @endisset
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- products Bannerr -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> منتجاتنا</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" name="content[products_banner][enable]" type="checkbox" id="flexSwitchCheckChecked" value="active" @if(isset($page->content['products_banner']['enable']) && $page->content['products_banner']['enable'] == 'active') checked @endif>
                                    <label class="form-check-label" style=" float: left;" for="flexSwitchCheckChecked">عرض القسم</label>
                                </div>
                                <div class="settings-page" style="cursor: pointer">
                                    <a class="btn btn-warning btn-sm" data-bs-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        اعدادات القسم
                                    </a>
                                    <div class="collapse" id="collapseExample4">
                                        <div class="card card-body">
                                            <div class="mb-3">
                                                <label>عنوان رئيسي</label>
                                                <input name="content[products_banner][heading]" @isset($page->content['products_banner']['heading']) value="{{ $page->content['products_banner']['heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>عنوان فرعي</label>
                                                <input name="content[products_banner][sub_heading]" @isset($page->content['products_banner']['sub_heading']) value="{{ $page->content['products_banner']['sub_heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- contact Bannerr -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> تواصل معنا</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" name="content[contact_banner][enable]" type="checkbox" id="flexSwitchCheckChecked" value="active" @if(isset($page->content['contact_banner']['enable']) && $page->content['contact_banner']['enable'] == 'active') checked @endif>
                                    <label class="form-check-label" style=" float: left;" for="flexSwitchCheckChecked">عرض القسم</label>
                                </div>
                                <div class="settings-page" style="cursor: pointer">
                                    <a class="btn btn-warning btn-sm" data-bs-toggle="collapse" href="#collapseExample66" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        اعدادات القسم
                                    </a>
                                    <div class="collapse" id="collapseExample66">
                                        <div class="card card-body">
                                            <div class="mb-3">
                                                <label>عنوان رئيسي</label>
                                                <input name="content[contact_banner][heading]" @isset($page->content['contact_banner']['heading']) value="{{ $page->content['contact_banner']['heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>نص فرعي</label>
                                                <textarea name="content[contact_banner][description]" class="form-control">@isset($page->content['contact_banner']['description']) {{ $page->content['contact_banner']['description'] }} @endisset</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- why_choice_us Bannerr -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> لماذا نحن</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" name="content[why_choice_us_banner][enable]" type="checkbox" id="flexSwitchCheckChecked" value="active" @if(isset($page->content['why_choice_us_banner']['enable']) && $page->content['why_choice_us_banner']['enable'] == 'active') checked @endif>
                                    <label class="form-check-label" style=" float: left;" for="flexSwitchCheckChecked">عرض القسم</label>
                                </div>
                                <div class="settings-page" style="cursor: pointer">
                                    <a class="btn btn-warning btn-sm" data-bs-toggle="collapse" href="#collapseExample5" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        اعدادات القسم
                                    </a>
                                    <div class="collapse" id="collapseExample5">
                                        <div class="card card-body">
                                            <div class="mb-3">
                                                <label>عنوان رئيسي</label>
                                                <input name="content[why_choice_us_banner][heading]" @isset($page->content['why_choice_us_banner']['heading']) value="{{ $page->content['why_choice_us_banner']['heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>عنوان فرعي</label>
                                                <input name="content[why_choice_us_banner][sub_heading]" @isset($page->content['why_choice_us_banner']['sub_heading']) value="{{ $page->content['why_choice_us_banner']['sub_heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>نص وصفي</label>
                                                <textarea name="content[why_choice_us_banner][description]" class="form-control summernote">@isset($page->content['why_choice_us_banner']['description']) {{ $page->content['why_choice_us_banner']['description'] }} @endisset</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <div class="container-uploader">
                                                    <button type="button" class="btn btn-outline-warning btn-sm upload-media" data-type-media="image">
                                                        <i class='bx bx-upload' ></i>
                                                        اضافة صورة
                                                       <input type="hidden" name="content[why_choice_us_banner][thumbnail_id]" @isset($page->content['why_choice_us_banner']['thumbnail_id']) value="{{ $page->content['why_choice_us_banner']['thumbnail_id'] }}" @endisset
                                                            class="form-control dob-picker uploaded-media-ids" required/>
                                                    </button>
                                                    <div class="preview-thumbs">
                                                        <br/>
                                                        <ul class="list-preview-thumbs">
                                                            @isset($page->content['why_choice_us_banner']['thumbnail_id'])
                                                                @include('partials.media_preview_list',['media_id' => $page->content['why_choice_us_banner']['thumbnail_id']])
                                                            @endisset
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>النسب المئوية</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>رقم </label>
                                                                    <input name="content[why_choice_us_banner][percentage_number][0]" @isset($page->content['why_choice_us_banner']['percentage_number'][0]) value="{{ $page->content['why_choice_us_banner']['percentage_number'][0] }}" @endisset  class="form-control"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>عنوان </label>
                                                                    <input name="content[why_choice_us_banner][percentage_title][0]" @isset($page->content['why_choice_us_banner']['percentage_title'][0]) value="{{ $page->content['why_choice_us_banner']['percentage_title'][0] }}" @endisset  class="form-control"/>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>رقم </label>
                                                                    <input name="content[why_choice_us_banner][percentage_number][1]" @isset($page->content['why_choice_us_banner']['percentage_number'][1]) value="{{ $page->content['why_choice_us_banner']['percentage_number'][1] }}" @endisset  class="form-control"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>عنوان </label>
                                                                    <input name="content[why_choice_us_banner][percentage_title][1]" @isset($page->content['why_choice_us_banner']['percentage_title'][1]) value="{{ $page->content['why_choice_us_banner']['percentage_title'][1] }}" @endisset  class="form-control"/>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>رقم </label>
                                                                    <input name="content[why_choice_us_banner][percentage_number][2]" @isset($page->content['why_choice_us_banner']['percentage_number'][2]) value="{{ $page->content['why_choice_us_banner']['percentage_number'][2] }}" @endisset  class="form-control"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>عنوان </label>
                                                                    <input name="content[why_choice_us_banner][percentage_title][2]" @isset($page->content['why_choice_us_banner']['percentage_title'][2]) value="{{ $page->content['why_choice_us_banner']['percentage_title'][2] }}" @endisset  class="form-control"/>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- ------------------------------------------------------------------------------------->
                        <!-- our reviews Bannerr -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> اراء العملاء</label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" name="content[our_reviews_banner][enable]" type="checkbox" id="flexSwitchCheckChecked" value="active" @if(isset($page->content['our_reviews_banner']['enable']) && $page->content['our_reviews_banner']['enable'] == 'active') checked @endif>
                                    <label class="form-check-label" style=" float: left;" for="flexSwitchCheckChecked">عرض القسم</label>
                                </div>
                                <div class="settings-page" style="cursor: pointer">
                                    <a class="btn btn-warning btn-sm" data-bs-toggle="collapse" href="#collapseExample77" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        اعدادات القسم
                                    </a>
                                    <div class="collapse" id="collapseExample77">
                                        <div class="card card-body">
                                            <div class="mb-3">
                                                <label>عنوان الرئيسية</label>
                                                <input name="content[our_reviews_banner][heading]" @isset($page->content['our_reviews_banner']['heading']) value="{{ $page->content['our_reviews_banner']['heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <label>عنوان فرعي</label>
                                                <input name="content[our_reviews_banner][sub_heading]" @isset($page->content['our_reviews_banner']['sub_heading']) value="{{ $page->content['our_reviews_banner']['sub_heading'] }}" @endisset  class="form-control"/>
                                            </div>
                                            <div class="mb-3">
                                                <div class="container-uploader">
                                                    <button type="button" class="btn btn-outline-warning btn-sm upload-media" data-type-media="image">
                                                        <i class='bx bx-upload' ></i>
                                                        اضافة صورة
                                                       <input type="hidden" name="content[our_reviews_banner][thumbnail_id]" @isset($page->content['our_reviews_banner']['thumbnail_id']) value="{{ $page->content['our_reviews_banner']['thumbnail_id'] }}" @endisset
                                                            class="form-control dob-picker uploaded-media-ids" required/>
                                                    </button>
                                                    <div class="preview-thumbs">
                                                        <br/>
                                                        <ul class="list-preview-thumbs">
                                                            @isset($page->content['our_reviews_banner']['thumbnail_id'])
                                                                @include('partials.media_preview_list',['media_id' => $page->content['our_reviews_banner']['thumbnail_id']])
                                                            @endisset
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>أراء العملاء </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>اسم العميل</label>
                                                                    <input name="content[our_reviews_banner][reviewer_name][0]" @isset($page->content['our_reviews_banner']['reviewer_name'][0]) value="{{ $page->content['our_reviews_banner']['reviewer_name'][0] }}" @endisset  class="form-control"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>نص التقيم </label>
                                                                    <textarea name="content[our_reviews_banner][reviewer_description][0]" class="form-control">{{ isset($page->content['our_reviews_banner']['reviewer_description'][0]) ? $page->content['our_reviews_banner']['reviewer_description'][0] : '' }}</textarea>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>اسم العميل</label>
                                                                    <input name="content[our_reviews_banner][reviewer_name][1]" @isset($page->content['our_reviews_banner']['reviewer_name'][1]) value="{{ $page->content['our_reviews_banner']['reviewer_name'][1] }}" @endisset  class="form-control"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>نص التقيم </label>
                                                                    <textarea name="content[our_reviews_banner][reviewer_description][1]" class="form-control">{{ isset($page->content['our_reviews_banner']['reviewer_description'][1]) ? $page->content['our_reviews_banner']['reviewer_description'][1] : '' }}</textarea>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>اسم العميل</label>
                                                                    <input name="content[our_reviews_banner][reviewer_name][2]" @isset($page->content['our_reviews_banner']['reviewer_name'][2]) value="{{ $page->content['our_reviews_banner']['reviewer_name'][2] }}" @endisset  class="form-control"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>نص التقيم </label>
                                                                    <textarea name="content[our_reviews_banner][reviewer_description][2]" class="form-control">{{ isset($page->content['our_reviews_banner']['reviewer_description'][2]) ? $page->content['our_reviews_banner']['reviewer_description'][2] : '' }}</textarea>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>اسم العميل</label>
                                                                    <input name="content[our_reviews_banner][reviewer_name][3]" @isset($page->content['our_reviews_banner']['reviewer_name'][3]) value="{{ $page->content['our_reviews_banner']['reviewer_name'][3] }}" @endisset  class="form-control"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <label>نص التقيم </label>
                                                                    <textarea name="content[our_reviews_banner][reviewer_description][3]" class="form-control">{{ isset($page->content['our_reviews_banner']['reviewer_description'][3]) ? $page->content['our_reviews_banner']['reviewer_description'][3] : '' }}</textarea>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($page->slug == 'shop')
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> تفاصيل الصفحة</label>
                                </div>
                                <div class="mb-3">
                                    <label>عنوان فرعي</label>
                                    <input name="content[shop][sub_heading]" @isset($page->content['shop']['sub_heading']) value="{{ $page->content['shop']['sub_heading'] }}" @endisset  class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label>عنوان الرئيسية</label>
                                    <input name="content[shop][heading]" @isset($page->content['shop']['heading']) value="{{ $page->content['shop']['heading'] }}" @endisset  class="form-control"/>
                                </div>
                            </div>
                        </div>
                    @elseif($page->slug == 'services')
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> تفاصيل الصفحة</label>
                                </div>
                                <div class="mb-3">
                                    <label>عنوان فرعي</label>
                                    <input name="content[services][sub_heading]" @isset($page->content['services']['sub_heading']) value="{{ $page->content['services']['sub_heading'] }}" @endisset  class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label>عنوان الرئيسية</label>
                                    <input name="content[services][heading]" @isset($page->content['services']['heading']) value="{{ $page->content['services']['heading'] }}" @endisset  class="form-control"/>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> محتوي الصفحة</label>
                                    <textarea id="basic-default-message" class="form-control summernote"  rows="10" placeholder="" name='content'>{{ $page->content }}</textarea>
                                    @error('content')
                                        <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="container-uploader">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" name="status" type="checkbox" id="flexSwitchCheckChecked" value="active" @if($page->status == 'active') checked @endif>
                                        <label class="form-check-label" for="flexSwitchCheckChecked">allow to show page</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-default-fullname">موضع الصفحة </label>
                                <select type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="position" value="{{ old('position') }}" required>
                                    <option value="header" @if($page->position == 'header') selected @endif>القائمة العلوية</option>
                                    <option value="footer" @if($page->position == 'footer') selected @endif>القائمة السفلية</option>
                                    <option value="both"   @if($page->position == 'both')   selected @endif>كلا القائمتين   </option>
                                    <option value="hidden" @if($page->position == 'hidden')   selected @endif>بدون قائمة  </option>
                                </select>
                                @error('position')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-default-fullname">ترتيب الصفحة</label>
                                @php $pages = \App\Models\Page::all() @endphp
                                <select type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="menu_position" value="{{ old('menu_position') }}" required>
                                    <option value="10" @if(10 == $page->menu_position) selected @endif> اول القائمة </option>
                                    @foreach($pages as $custom_page)
                                        @php $page_prev = ( $custom_page->menu_position != null ? $custom_page->menu_position : $custom_page->id) - 1  @endphp
                                        @php $page_next = ( $custom_page->menu_position != null ? $custom_page->menu_position : $custom_page->id) + 1  @endphp
                                        <option value="{{ $page_prev }}" @if($page_prev == $page->menu_position) selected @endif> قبل {{ $custom_page->title }}  </option>
                                        <option value="{{ $page_next }}" @if($page_next == $page->menu_position) selected @endif> بعد {{ $custom_page->title }}  </option>
                                    @endforeach
                                    <option value="1000" @if(1000 == $page->menu_position) selected @endif> أخر القائمة</option>
                                </select>
                                @error('menu_position')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @if(IsPagesAllowDeletes($page->slug))
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="container-uploader">
                                        <button type="button" class="btn btn-warning btn-sm upload-media" data-type-media="image">
                                            <i class='bx bx-upload' ></i>
                                            اضافة صورة للصفحة
                                            <input type="hidden" name="thumbnail_id" value="{{ $page->thumbnail_id }}"
                                                class="form-control dob-picker uploaded-media-ids" required/>
                                        </button>
                                        @error('thumbnail_id')
                                            <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                        @enderror
                                        <div class="preview-thumbs">
                                            <br/>
                                            <ul class="list-preview-thumbs">
                                                @if($page->thumbnail_id)
                                                    <li class="preview-media-inner">
                                                        <img src="{{ upload_assets($page->image_info) }}" />
                                                        <i class='bx bxs-message-square-x remove' media-id="{{ $page->thumbnail_id }}"></i>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company">عنوان السيو ( meta title )</label>
                                <input type="text" id="basic-icon-default-company" class="form-control" name="meta_title"
                                    value="{{ $page->meta_title ?: old('meta_title') }}" />
                                @error('meta_title')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company">وصف السيو ( meta description ) </label>
                                <textarea type="text" id="basic-icon-default-company" class="form-control"
                                    name="meta_description">{{ $page->meta_description ?: old('meta_description') }}</textarea>
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
<style>
    label{
        line-height: 3em;
    }
</style>
@endpush
