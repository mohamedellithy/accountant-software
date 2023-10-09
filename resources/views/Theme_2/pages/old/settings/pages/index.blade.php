@extends('layouts.master')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">
           اعدادات الصفحات
        </h4>
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('admin.settings.pages.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="mb-3">
                                <h5 for="basic-default-fullname">اضافة صفحة جديدة</h5>
                            </div>
                        </div>
                        <div class="card-body form-create-page d-flex">
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-default-fullname">اسم الصفحة</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="title" value="{{ old('title') }}" required/>
                                @error('title')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-default-fullname">رابط الصفحة</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="slug" value="{{ old('slug') }}"/>
                                @error('slug')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-default-fullname">موضع الصفحة </label>
                                <select type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="position" value="{{ old('position') }}" required>
                                    <option value="header">القائمة العلوية</option>
                                    <option value="footer">القائمة السفلية</option>
                                    <option value="both"  >كلا القائمتين   </option>
                                </select>
                                @error('position')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="basic-default-fullname">حالة الصفحة</label>
                                <select type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="status" value="{{ old('status') }}" required>
                                    <option value="active">فعالة </option>
                                    <option value="not-active">غير فعالة</option>
                                </select>
                                @error('status')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">
                                    اضافة صفحة جديدة
                                </button>
                            </div>
                        </div>
                        </div>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="mb-3">
                            <h5 for="basic-default-fullname">الصفحات</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>الرابط</th>
                                        <th>موضع الصفحة</th>
                                        <th>حالة الصفحة</th>
                                        <th>تاريخ الانشاء</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0 alldata">
                                    @foreach($pages as $page)
                                        <tr>
                                            <td>
                                                {{ $page->title }}
                                            </td>
                                            <td>
                                                {{ $page->slug }}
                                            </td>
                                            <td>
                                                @if($page->position == 'header')
                                                    القائمة العلوية
                                                @elseif($page->position == 'footer')
                                                    القائمة السفلية
                                                @elseif($page->position == 'both')
                                                    كلا القائمتين       
                                                @elseif($page->position == 'hidden')
                                                    بدون قائمة  
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-label-danger me-1">
                                                    {{ $page->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-label-info me-1">
                                                    {{ $page->created_at }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.settings.pages.edit', $page->id) }}"><i
                                                                class="bx bx-edit-alt me-2"></i>
                                                            تعديل
                                                        </a>
                                                        @if(IsPagesAllowDeletes($page->slug))
                                                            <form action="{{ route('admin.settings.pages.destroy', $page->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item">
                                                                    <i class="bx bx-trash me-2"></i>حذف
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <a class="dropdown-item" target="_blank"
                                                            href="{{ url($page->slug) }}"><i
                                                                class="fa-regular fa-eye me-2"></i></i>عرض
                                                        </a>
                                                        
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex flex-row justify-content-center">
                                {{ $pages->links() }}
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection
