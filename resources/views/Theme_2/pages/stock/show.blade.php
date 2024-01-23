 <!-- Begin Page Content -->
 @extends('Theme_2.layouts.master')

 @section('content')
     <div class="container-fluid">

         <!-- Page Heading -->
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
             <h1 class="h3 mb-0 text-gray-800">{{ $product->name }}</h1>
         </div>
         <div class="row">
             <div class="col-lg-6">
                 <!-- Basic Card Example -->
                 <div class="card shadow mb-4">
                     <div class="card-header py-3">
                         <h6 class="m-0 font-weight-bold text-primary">الصنف :{{ $product->name }}</h6>
                     </div>
                     <div class="card-body">
                    <p>   الكمية :{{ $product->quantity }}</p>
                    <p>   السعر :{{ $product->price }}</p>
                    <p>   اسم المورد :{{ $product->supplier ? $product->supplier->name : '-' }}</p>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- /.container-fluid -->
 @endsection
