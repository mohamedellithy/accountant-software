@extends('layouts.master')
@php
$search = request()->query('search') ?: null;
$filter = request()->query('filter') ?: null;
$rows   = request()->query('rows')   ?: 10;
@endphp
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            تقيمات المنتجات
        </h4>
        <!-- Basic Bootstrap Table -->
        <div class="card" style="padding-top: 3%;">
            <form id="filter-data" method="get">
                <div class="d-flex filters-fields">
                    <div class="nav-item d-flex align-items-center m-2" >
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input type="text" class="search form-control border-0 shadow-none" placeholder="البحث ...."
                            @isset($search) value="{{ $search }}" @endisset id="search" name="search"/>
                    </div>
                    <div class="nav-item d-flex align-items-center m-2" >
                        <select name="filter" id="largeSelect"  onchange="document.getElementById('filter-data').submit()" class="form-select form-select-md">
                            <option>فلتر المنتجات</option>
                            <option value="sort_asc"   @isset($filter) @if($filter == 'sort_asc') selected @endif @endisset>الطلبات الاقدم</option>
                            <option value="sort_desc"  @isset($filter) @if($filter == 'sort_desc') selected @endif @endisset>الطلبات الأحدث</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="nav-item d-flex align-items-center m-2" >
                        <label style="padding: 0px 10px;color: #636481;">المعروض</label>
                        <select name="rows" onchange="document.getElementById('filter-data').submit()" id="largeSelect" class="form-select form-select-sm">
                            <option>10</option>
                            <option value="50" @isset($rows) @if($rows == '50') selected @endif @endisset>50</option>
                            <option value="100" @isset($rows) @if($rows == '100') selected @endif @endisset>100</option>
                        </select>
                    </div>
                </div>
            </form>
            <br/>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>اسم الزبون</th>
                            <th>المنتج</th>
                            <th>نص التقيم</th>
                            <th>التقيم</th>
                            <th>تاريخ التقيم</th>
                            <th>حالة التقيم</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0 alldata">
                        @foreach($reviews as $review)
                            <tr>
                                <td class="width-16">{{ $review->customer->name }}</td>
                                <td class="width-16">
                                    {{ $review->product->name }}
                                </td>
                                <td class="">
                                    {{ TrimLongText($review->review) }}
                                </td>
                                <td class="width-16 rating">
                                    @if($review->degree)
                                        @if($review->degree > 5)
                                            @php $review->degree = 5 @endphp
                                        @endif

                                        ( {{ $review->degree }} )
                                        @for($i = 1;$i <= $review->degree;$i++)
                                            <i class="fas fa-star active" style="font-size: 12px;"></i>
                                        @endfor

                                        @for($i=1;$i <= 5-$review->degree;$i++)
                                            <i class="fas fa-star" style="font-size: 12px;"></i>
                                        @endfor
                                    @else
                                        <i class="fas fa-star" style="font-size: 12px;"></i>
                                        <i class="fas fa-star" style="font-size: 12px;"></i>
                                        <i class="fas fa-star" style="font-size: 12px;"></i>
                                        <i class="fas fa-star" style="font-size: 12px;"></i>
                                        <i class="fas fa-star" style="font-size: 12px;"></i>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge" style="color:black">
                                        {{ $review->created_at }}
                                    </span>
                                </td>
                                <td>
                                    @if($review->status == 'active')
                                        <span class="badge bg-label-primary me-1">
                                            معروض
                                        </span>
                                    @else
                                        <span class="badge bg-label-danger me-1">
                                            مخفي
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.reviews.show', $review->id) }}"><i
                                                    class="fa-regular fa-eye me-2"></i></i>
                                                عرض
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br/>
                <div class="d-flex flex-row justify-content-center">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
@endsection
