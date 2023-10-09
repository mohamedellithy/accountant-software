 @extends('layouts.master')
 @php
     $search = request()->query('search') ?: null;
     $rows = request()->query('rows') ?: 10;
     $filter = request()->query('filter') ?: null;
 @endphp
 @section('content')
     <div class="container-fluid">
         <!-- Page Heading -->
         <h1 class="h3 mb-2 text-gray-800">الاصناف</h1>

         <!-- DataTales Example -->
         <div class="card shadow mb-4">
             <div class="card-header py-3 ">
                 <form id="filter-data" method="get" class="d-flex justify-content-between">
                     <div class="nav-item d-flex align-items-center m-2">
                         <i class="bx bx-search fs-4 lh-0"></i>
                         <input type="text" class="search form-control border-0 shadow-none" placeholder="البحث ...."
                             @isset($search) value="{{ $search }}" @endisset id="search"
                             name="search" />
                     </div>
                     <div class="d-flex">
                         <div class="nav-item d-flex align-items-center m-2">
                             <select name="filter" id="largeSelect"
                                 onchange="document.getElementById('filter-data').submit()" class="form-control">
                                 <option>فلتر الاصناف</option>
                                 <option value="high-price"
                                     @isset($filter) @if ($filter == 'high-price') selected @endif @endisset>
                                     الاعلي سعرا</option>
                                 <option value="low-price"
                                     @isset($filter) @if ($filter == 'low-price') selected @endif @endisset>
                                     الاقل سعرا</option>

                             </select>
                         </div>
                         <div class="nav-item d-flex align-items-center m-2">
                             <label style="padding: 0px 10px;color: #636481;">المعروض</label>
                             <select name="rows" onchange="document.getElementById('filter-data').submit()"
                                 id="largeSelect" class="form-select form-select-sm">
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
             </div>

             <div class="card-body">
                 <div class="table-responsive">
                     <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                         <thead>
                             <tr>
                                 <th>الاسم</th>
                                 <th>الكمية </th>
                                 <th>السعر </th>
                                 <th>اسم المورد </th>
                                 <th>العمليات</th>

                             </tr>
                         </thead>

                         <tbody>
                             @foreach ($products as $product)
                                 <tr>
                                     <td>{{ $product->name }}</td>
                                     <td>{{ $product->quantity }}</td>
                                     <td>{{ $product->price }}</td>
                                     <td>{{ $product->supplier->name }}</td>
                                     <td>
                                         <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                             class="d-flex ">

                                             <a class="crud" href="{{ route('products.edit', $product->id) }}">
                                                 <i class="fas fa-edit text-primary"></i></a>
                                             @csrf
                                             @method('DELETE')
                                             <button type="submit" class="crud">
                                                 <i class="fas fa-trash-alt  text-danger"></i>
                                             </button>
                                             <a class="crud" href="{{ route('products.show', $product->id) }}">
                                                 <i class="far fa-eye"></i>
                                             </a>
                                         </form>
                                     </td>

                                 </tr>
                             @endforeach


                         </tbody>
                     </table>
                     <div class="d-flex flex-row justify-content-center">
                         {{ $products->links() }}
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
