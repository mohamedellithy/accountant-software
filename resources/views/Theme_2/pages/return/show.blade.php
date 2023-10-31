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
                <div class="card mb-4" id="DivIdToPrint">

<style>
  @media screen, print {
  .body-print #DivIdToPrint{
    width: 551px !important;
    border: 2px solid red !important;
    }
      .body-print table{
        border:1px solid;
        width:100%;
        margin-top:10px
      }
     .body-print .table-light th{
        color: #566a7f !important;
        border-left: 1px solid;
    }
     .body-print .table tr{
        border : 1px solid gray
    }
     .body-print .table td{
        border: 1px solid #cac7c7;
        text-align: center;
    }
     .body-print .invoice-header{
        flex-direction: row !important;
        justify-content: space-between !important;
        align-items: center !important;

    }

     .body-print .invoice-header .date{
        margin-right:600px !important;

    }
     .body-print .invoice-header .date span{
        padding: 10px;
    }
     .body-print .footer .signature{
        margin-right:410px !important;

    }
     .body-print .custom .customsce{
        margin-right:510px !important;

    }

  }
 </style>
                    <div class="card-header py-3">

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
                        <div class="d-flex custom" style="justify-content: space-between;">
                            <label>
                                <strong>
                                     المطلوب من السيد /
                                </strong>

                            </label>
                            <label> <strong class="customsce">فاتورة رقم  ({{ $customerReturn->order_number }}) </strong></label>
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
                        <div class="d-flex footer" style="justify-content: space-between;padding-top: 15px;">
                            <label>
                                <strong>
                                    المستلم /
                                </strong>

                            </label>
                            <label>
                                <strong  class="signature">
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
                    <a href="{{ route('admin.purchasing-invoices.edit',$customerReturn->id) }}" class="btn btn-danger btn-sm">
                                        تعديل الفاتورة
                                        </a>
                        <div class="d-flex">
                        <button type='button' id='btn' value='Print' onclick='printDiv();' class="btn btn-primary btn-sm mt-2">طباعة الفاتورة</button>&nbsp;&nbsp;
                        <form action="{{ route('admin.teckScreen') }}" method="post">
                              @csrf
                        <input type="hidden" name="phone" value="{{ $customerReturn->customer->phone }}">

                        <input type="hidden" name="url" value="{{ url()->current()  }}">

                        <button type='submit' id='btn' class="btn btn-success btn-sm mt-2">  ارسال الفاتورة على الواتس</button>
                        </form>
                        </div>

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
    @media(max-width:1000px){
        .table:not(.table-dark) tr th:first-child, 
        .table:not(.table-dark) tr th:nth-child(2){
            background-color:white !important;
        }
        .invoice-header .head{
            font-size: 10px;
        }
        .invoice-header .date{
            font-size: 8px;
        }
    }
 </style>
 @endpush

@push('script')
    <script type="text/javascript">
     function printDiv()
{

  var divToPrint=document.getElementById('DivIdToPrint');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body class="body-print" dir="rtl" onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}


</script>
@endpush
