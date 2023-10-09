 <!-- Begin Page Content -->
 @extends('layouts.master')

 @section('content')
     <div class="container-fluid">

         <!-- Page Heading -->
         <div class="d-sm-flex align-items-center justify-content-between mb-4">
             <h1 class="h3 mb-0 text-gray-800">{{ $supplier->name }}</h1>
         </div>
         <div class="row">
             <div class="col-lg-6 text-center">
                 <!-- Basic Card Example -->
                 <div class="card shadow mb-4">
                     <div class="card-header py-3">
                         <h6 class="m-0 font-weight-bold text-primary">الاسم :{{ $supplier->name }}</h6>
                     </div>
                     <div class="card-body">
                        رقم الهاتف :{{ $supplier->phone }}
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- /.container-fluid -->
 @endsection
