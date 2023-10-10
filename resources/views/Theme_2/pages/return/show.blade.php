 <!-- Begin Page Content -->
 @extends('Theme_2.layouts.master')

 @section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
           {{--  <h1 class="h3 mb-0 text-gray-800">{{ $customerReturn->order_number }}</h1> --}}
        </div>
        <div class="row">
            <div class="col-lg-8">
                 <!-- Basic Card Example -->
                <div class="card mb-4">
                    <div class="card-header py-3">
                        {{-- <h5 class="m-0 font-weight-bold text-warning">
                             فاتورة رقم  {{ $customerReturn->order_number }}
                        </h5> --}}
                        <div class="d-flex invoice-header">
                            <div class="">
                                <strong>Green Egypt</strong><br/>
                                <strong>جرين ايجبت للمبيدات و الاسمدة</strong>
                            </div>
                            <div class="date d-flex">
                                <strong>تحرير في </strong>
                                <span>12 / 12 / 2012</span>
                            </div>
                        </div>
                        <br/>
                        <div class="d-flex" style="justify-content: space-between;">
                            <label>
                                <strong>
                                     المطلوب من السيد /
                                </strong>
                                {{ $customerReturn->customer->name }}
                            </label>
                            <label>فاتورة رقم  ({{ $customerReturn->order_number }})</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        <th>البيان</th>
                                        <th>الكمية</th>
                                        <th>السعر</th>
                                        <th>الاجمالى</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customerReturn->returnitems as $return_item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $return_item->product->name }}</td>
                                            <td>{{ $return_item->quantity }}</td>
                                            <td>{{ formate_price($return_item->price) }}</td>
                                            <td>{{ formate_price($return_item->price * $return_item->quantity)  }}</td>
                                        </tr>
                                    @endforeach


                                    <tr>
                                        <td></td>
                                        <td>
                                            اجمالى القيمة النهائية
                                        </td>
                                        <td colspan="4" style="text-align: left;padding-left: 56px;">{{ formate_price($customerReturn->total_price) }}</td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex" style="justify-content: space-between;padding-top: 15px;">
                            <label>
                                <strong>
                                    المستلم /
                                </strong>
                                {{ $customerReturn->customer->name }}
                            </label>
                            <label>
                                <strong>
                                    التوقيع /
                                </strong>
                                ............................................................
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Basic Card Example -->
               <div class="card mb-4">
                   <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <p>فاتورة رقم</p>
                            <p class="text-dark" style="padding: 13px;background-color:#eee">{{ $customerReturn->order_number }}</p>
                        </h6>
                        <h6 class="m-0 font-weight-bold text-primary">
                            <p>اسم الزبون</p>
                            <p class="text-dark" style="padding: 13px;background-color:#eee">{{ $customerReturn->customer->name }}</p>
                        </h6>
                        <h6 class="m-0 font-weight-bold text-primary">
                            <p>رقم هاتف الزبون</p>
                            <p class="text-dark" style="padding: 13px;background-color:#eee">{{ $customerReturn->customer->phone }}</p>
                        </h6>
                   </div>
                   <div class="card-body">
                        <button class="btn btn-danger btn-sm">تعديل الفاتورة</button><br/><br/>
                        <button class="btn btn-primary btn-sm">طباعة الفاتورة</button>
                        <button class="btn btn-success btn-sm">ارسال الفاتورة على الواتس</button>
                   </div>
               </div>
           </div>
        </div>
    </div>
    <!-- /.container-fluid -->
 @endsection


 @push('style')
 <style>
     .table-light th{
        color: #566a7f !important;
        border-left: 1px solid lightgray;
    }
    .table tr{
        border : 1px solid gray
    }
    .table td{
        border: 1px solid #cac7c7;
        /* text-align: left; */
    }
    .invoice-header{
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
    .invoice-header .date{
        align-items: center;
    }
    .invoice-header .date span{
        padding: 10px;
    }
 </style>
 @endpush
