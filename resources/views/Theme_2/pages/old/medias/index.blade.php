@extends('layouts.master')

@php
$media_type = request('media_type');
@endphp
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">
           اعدادات المنصة
        </h4>
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="mb-3">
                            <h5 for="basic-default-fullname">اعدادات عامة</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="nav-item d-flex align-items-center m-2" >
                                <form id="filter-data" method="get">
                                    <select name="media_type" onchange="document.getElementById('filter-data').submit()" id="largeSelect" class="form-select  form-select-md">
                                        <option value="">كل الوسائط</option>
                                        <option value="image/png"  @isset($media_type) @if($media_type == 'image/png') selected @endif @endisset>IMAGE/PNG</option>
                                        <option value="image/jpg"  @isset($media_type) @if($media_type == 'image/jpg') selected @endif @endisset>IMAGE/JPG</option>
                                        <option value="image/jpeg" @isset($media_type) @if($media_type == 'image/jpeg') selected @endif @endisset>IMAGE/JPEG</option>
                                        <option value="video/mp4"  @isset($media_type) @if($media_type == 'video/mp4') selected @endif @endisset>IMAGE/MP4</option>
                                        <option value="application/pdf"  @isset($media_type) @if($media_type == 'application/pdf') selected @endif @endisset>Application/PDF</option>
                                        <option value="text/csv"  @isset($media_type) @if($media_type == 'text/csv') selected @endif @endisset>Text/csv</option>
                                        <option value="text/xlx"  @isset($media_type) @if($media_type == 'text/xlx') selected @endif @endisset>Text/xlx</option>
                                    </select>
                                </form>
                            </div>
                            <div class="nav-item d-flex align-items-center m-2" >
                                <form action="{{ route('admin.medias.delete_all') }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger delete-media">حذف الكل</button>
                                </form>
                            </div>
                        </div>
                        <div class="row container-media">
                            <div class="media-card d-flex">
                                @foreach($medias as $media)
                                    @include('partials.media_list_2')
                                @endforeach
                            </div>
                            <br/>
                            <div class="alert text-center">
                                {{ $medias->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection
