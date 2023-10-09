@extends('layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            الخدمات
        </h4>
        <!-- Basic Bootstrap Table -->
        <div class="card" style="padding-top: 3%;">
            <form id="filter-data" method="get">
                <div class="d-flex filters-fields">
                    <div class="nav-item d-flex align-items-center m-2">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input type="text" class="search form-control border-0 shadow-none" placeholder="البحث ...."
                            id="search" name="search" />
                    </div>
                    <div class="nav-item d-flex align-items-center m-2">
                        <select name="whatsapStatus" id="whatsapStatus" class="form-select form-select-md">
                            <option {{ is_null(request()->input('whatsapStatus')) ? 'selected' : '' }} value=""> حالة
                                الواتساب
                            </option>
                            <option {{ request()->input('whatsapStatus') == 1 ? 'selected' : '' }} value="1">مفعل
                            </option>
                            <option
                                {{ !is_null(request()->input('whatsapStatus')) && request()->input('whatsapStatus') == 0 ? 'selected' : '' }}
                                value="0">معطل </option>
                        </select>
                    </div>
                    <div class="nav-item d-flex align-items-center m-2">
                        <select name="loginStatus" id="loginStatus" class="form-select form-select-md">
                            <option {{ is_null(request()->input('loginStatus')) ? 'selected' : '' }} value=""> حالة التسجيل
                            </option>
                            <option {{ request()->input('loginStatus') == 1 ? 'selected' : '' }} value="1">مفعل
                            </option>
                            <option
                                {{ !is_null(request()->input('loginStatus')) && request()->input('loginStatus') == 0 ? 'selected' : '' }}
                                value="0">معطل</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="nav-item d-flex align-items-center m-2">
                        <label style="padding: 0px 10px;color: #636481;">المعروض</label>
                        <select name="rows" onchange="document.getElementById('filter-data').submit()" id="largeSelect"
                            class="form-select form-select-sm">
                            <option>10</option>
                            <option value="50"
                                @isset($rows) @if ($rows == '50') selected @endif @endisset>
                                50</option>
                            <option value="100"
                                @isset($rows) @if ($rows == '100') selected @endif @endisset>
                                100</option>
                        </select>
                    </div>
                </div>
            </form>
            <br />
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>الصورة</th>
                            <th>الاسم</th>
                            <th>الوصف</th>
                            <th>حالة الواتساب</th>
                            <th>رقم الواتساب</th>
                            <th>حالة التسجيل</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @foreach ($services as $service)
                            <tr>
                                <td class="">
                                    <img src="{{ upload_assets($service->image_info) }}" alt="Avatar"
                                        class="rounded-circle">
                                </td>
                                <td class="width-16">{{ $service->name }}</td>
                                <td class="">
                                    {{ TrimLongText($service->description) }}
                                </td>
                                <td>
                                    @if ($service->whatsapStatus == 1)
                                        <span class="badge bg-label-success me-1">مفعل</span>
                                    @else
                                        <span class="badge bg-label-danger me-1">معطل</span>
                                    @endif

                                </td>
                                <td>{{ $service->whatsapNumber }}</td>

                                <td>
                                    @if ($service->loginStatus == 1)
                                        <span class="badge bg-label-success me-1">مفعل</span>
                                    @else
                                        <span class="badge bg-label-danger me-1">معطل</span>
                                    @endif

                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu">
                                            <form action="{{ route('admin.services.destroy', $service->id) }}"
                                                method="POST">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.services.edit', $service->id) }}"><i
                                                        class="bx bx-edit-alt me-2"></i>
                                                    تعديل</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">
                                                    <i class="bx bx-trash me-2"></i>حذف
                                                </button>
                                                <a class="dropdown-item" target="_blank"
                                                    href="{{ url('service/'.$service->slug) }}"><i
                                                        class="fa-regular fa-eye me-2"></i></i>عرض

                                                </a>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tbody id="content" class="searchdata"></tbody>
                    </tbody>
                </table>
                <br />
                <div class="d-flex flex-row justify-content-center">
                    {{ $services->links() }}
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
@endsection
@push('script')
    <script>
        $('#whatsapStatus, #search,#loginStatus').on('change', function() {
            $search = $('#search').val();
            $whatsapStatus = $('#whatsapStatus').val();
            $loginStatus = $('#loginStatus').val();
            console.log($search)
            console.log($whatsapStatus)
            console.log($loginStatus)

            if ($search || $whatsapStatus || $loginStatus) {
                $('.alldata').hide()
                $('.searchdata').show()

            } else {
                $('.alldata').show()
                $('.searchdata').hide()
            }
            $.ajax({
                url: '{{ route('search') }}',
                method: 'GET',
                data: {
                    search: $search,
                    whatsapStatus: $whatsapStatus,
                    loginStatus: $loginStatus
                },
                success: function(data) {
                    if (data._result.length > 0) {
                        console.log(data);
                        $('.searchdata').empty();
                        jQuery('.searchdata').append(data._result);

                    } else {

                        $('.searchdata').empty();
                        jQuery('.alldata').hide();


                    }
                    console.log('hi');
                }

            });
        });
    </script>
@endpush
