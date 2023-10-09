@extends('layouts.master')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">
           التقيم رقم  # {{ $review->id }}
        </h4>
        <form action="{{ route('admin.reviews.update',$review->id) }}" method="post">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="form-status-change" style="">
                    <div class="form-group">
                        <select name="status" class="form-control" style="height: 40px;">
                            <option value="active"   @if($review->status == 'active') selected @endif>معروض</option>
                            <option value="unactive" @if($review->status == 'unactive') selected @endif>مخفي</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">تعديل حالة التقيم</button>
                </div>
            </div>
        </form>
        <!-- Basic Layout -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body order-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <h5 class="heading"> التقيم</h5>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">كود التقيم</label>
                                        <h6 style="line-height: 1.3em;">#{{ $review->id }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">اسم الزبون</label>
                                        <h6 style="line-height: 1.3em;">{{ $review->customer->name }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">اسم المنتج</label>
                                        <h6 style="line-height: 1.3em;">{{ $review->product->name }}</h5>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">قيمة التقيم</label>
                                        <div class="rating">
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
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">اسم المنتج</label>
                                        <p style="line-height: 1.3em;">{{ $review->review }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">تاريخ الطلبية</label>
                                        <h6 style="line-height: 1.3em;">{{ $review->created_at }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body order-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        @if(!$review->replays->isEmpty())
                                            <h6 class="form-label" for="basic-default-fullname">رد المسؤلين</h6>
                                            <table class="table table-warning">
                                                @foreach($review->replays as $replay)
                                                    <tr>
                                                        <td>
                                                            {{ $replay->review }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        @else
                                          <div class="alert alert-danger">
                                            لايوجد ردود من قبل المسؤلين
                                          </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <form method="post" action="{{ route('admin.reviews.update',['review' => $review->id,'replay' =>true]) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body order-details">
                                <div class="mb-3">
                                    <h5 class="heading"> الرد على التعليق</h5>
                                </div>
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-fullname">نص التعليق</label>
                                        <textarea rows="5" name="review" class="form-control">{{ old('review') }}</textarea>
                                    </div>
                                    <div class="mb-3 text-left">
                                        <button type="submit" class="btn btn-primary btn-sm">اضافة رد</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body order-details">
                            <div class="mb-3">
                                <h5 class="heading"> تفاصيل الزبون</h5>
                            </div>
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">اسم الزبون</label>
                                    <h6 style="line-height: 1.3em;">{{ $review->customer->name }}</h6>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">البريد الالكترونى الزبون</label>
                                    <h6 style="line-height: 1.3em;">{{ $review->customer->email }}</h6>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">رقم تليفون الزبون</label>
                                    <h6 style="line-height: 1.3em;">{{ $review->customer->full_phone ?: '-' }}</h6>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">دولة </label>
                                    <h6 style="line-height: 1.3em;">{{ $review->customer->phone_code ? CountriesPhonesCode($review->customer->phone_code) : '-' }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body order-details">
                            <div class="mb-3">
                                <h5 class="heading"> تفاصيل المنتج</h5>
                            </div>
                            <div class="mb-3">
                                <div class="container-uploader">
                                    <div class="preview-thumbs">
                                        <ul class="list-preview-thumbs">
                                            @if($review->product->thumbnail_id)
                                                <li class="preview-media-inner" style="border: 10px solid gray;">
                                                    <img src="{{ upload_assets($review->product->image_info) }}" />
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">اسم الزبون</label>
                                    <h6 style="line-height: 1.3em;">{{ $review->product->name }}</h6>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">وصف المنتج</label>
                                    <p style="line-height: 1.3em;">{!! TrimLongText($review->product->description,100) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- / Content -->
@endsection
