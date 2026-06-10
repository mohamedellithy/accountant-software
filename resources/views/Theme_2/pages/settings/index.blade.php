@extends('Theme_2.layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="bx bx-cog text-success me-2"></i>إعدادات الفاتورة والمنشأة</h5>
                    <small class="text-muted">التحكم في بيانات الترويسة والتذييل للفواتير المطبوعة</small>
                </div>
                <div class="card-body mt-4">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Organization Name -->
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold" for="logo_pdf_title">اسم المؤسسة (يظهر في أعلى الفاتورة)</label>
                                <input type="text" class="form-control form-control-lg" id="logo_pdf_title" 
                                    name="logo_pdf_title" value="{{ old('logo_pdf_title', get_setting('logo_pdf_title', env('logo_pdf_title', 'الندى للتنمية الزراعية'))) }}" required />
                                @error('logo_pdf_title')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Manager Name -->
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold" for="manager_name">اسم المدير / المسؤول (يظهر في تذييل الفاتورة)</label>
                                <input type="text" class="form-control form-control-lg" id="manager_name" 
                                    name="manager_name" value="{{ old('manager_name', get_setting('manager_name', env('manager_name', 'رضا الحلواني'))) }}" />
                                @error('manager_name')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Mobile Number -->
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold" for="phone_number">رقم الجوال</label>
                                <input type="text" class="form-control form-control-lg" id="phone_number" 
                                    name="phone_number" value="{{ old('phone_number', get_setting('phone_number', env('phone_number', '01140005471'))) }}" />
                                @error('phone_number')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Telephone Number -->
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold" for="telephone">رقم التليفون الأرضي</label>
                                <input type="text" class="form-control form-control-lg" id="telephone" 
                                    name="telephone" value="{{ old('telephone', get_setting('telephone')) }}" placeholder="اختياري" />
                                @error('telephone')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Navbar Color -->
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold" for="navbar_color">لون شريط التنقل العلوي (Navbar)</label>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="color" class="form-control form-control-color" id="navbar_color" 
                                        name="navbar_color" value="{{ old('navbar_color', get_setting('navbar_color', '#ffffff')) }}" style="width: 60px; height: 45px; padding: 2px;" />
                                    <input type="text" class="form-control form-control-lg" id="navbar_color_text" value="{{ get_setting('navbar_color', '#ffffff') }}" readonly />
                                </div>
                                @error('navbar_color')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Sidebar Color -->
                            <div class="mb-3 col-md-6">
                                <label class="form-label fw-bold" for="sidebar_color">لون القائمة الجانبية (Sidebar)</label>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="color" class="form-control form-control-color" id="sidebar_color" 
                                        name="sidebar_color" value="{{ old('sidebar_color', get_setting('sidebar_color', '#1e293b')) }}" style="width: 60px; height: 45px; padding: 2px;" />
                                    <input type="text" class="form-control form-control-lg" id="sidebar_color_text" value="{{ get_setting('sidebar_color', '#1e293b') }}" readonly />
                                </div>
                                @error('sidebar_color')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Logo Upload -->
                            <div class="mb-4 col-md-12">
                                <label class="form-label fw-bold d-block" for="logo">شعار المؤسسة (اختياري)</label>
                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                    <div class="logo-preview-container bg-light border rounded p-2 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                        @if(get_setting('logo'))
                                            <img id="logo-preview-img" src="{{ get_setting('logo') }}" alt="Logo" class="img-fluid" style="max-height: 100px; object-fit: contain;">
                                        @else
                                            <div id="logo-preview-placeholder" class="text-muted text-center">
                                                <i class="bx bx-image fs-1 d-block mb-1"></i>
                                                <span style="font-size: 11px;">بدون شعار</span>
                                            </div>
                                            <img id="logo-preview-img" src="" alt="Logo" class="img-fluid d-none" style="max-height: 100px; object-fit: contain;">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*" onchange="previewLogo(this)" />
                                        <small class="text-muted d-block mt-1">الصيغ المدعومة: PNG, JPG, JPEG, SVG. الحجم الأقصى: 2 ميجابايت.</small>
                                    </div>
                                </div>
                                @error('logo')
                                    <span class="text-danger fs-6 d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-4"><i class="bx bx-save me-2"></i>حفظ الإعدادات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="bx bx-lock-open-alt text-danger me-2"></i>تغيير كلمة المرور</h5>
                    <small class="text-muted">تحديث كلمة مرور الحساب الخاصة بك</small>
                </div>
                <div class="card-body mt-4">
                    <form action="{{ route('admin.settings.change-password') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Current Password -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label fw-bold" for="current_password">كلمة المرور الحالية</label>
                                <input type="password" class="form-control form-control-lg" id="current_password" 
                                    name="current_password" required />
                                @error('current_password')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label fw-bold" for="new_password">كلمة المرور الجديدة</label>
                                <input type="password" class="form-control form-control-lg" id="new_password" 
                                    name="new_password" required />
                                @error('new_password')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label fw-bold" for="new_password_confirmation">تأكيد كلمة المرور الجديدة</label>
                                <input type="password" class="form-control form-control-lg" id="new_password_confirmation" 
                                    name="new_password_confirmation" required />
                                @error('new_password_confirmation')
                                    <span class="text-danger fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-danger btn-lg px-4"><i class="bx bx-key me-2"></i>تغيير كلمة المرور</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewLogo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var previewImg = document.getElementById('logo-preview-img');
                var placeholder = document.getElementById('logo-preview-placeholder');
                
                previewImg.src = e.target.result;
                previewImg.classList.remove('d-none');
                if (placeholder) {
                    placeholder.classList.add('d-none');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        var navColor = document.getElementById('navbar_color');
        if(navColor) {
            navColor.addEventListener('input', function() {
                document.getElementById('navbar_color_text').value = this.value;
            });
        }
        var sideColor = document.getElementById('sidebar_color');
        if(sideColor) {
            sideColor.addEventListener('input', function() {
                document.getElementById('sidebar_color_text').value = this.value;
            });
        }
    });
</script>
@endsection
