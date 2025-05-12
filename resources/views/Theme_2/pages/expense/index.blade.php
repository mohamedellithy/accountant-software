 @extends('Theme_2.layouts.master')
  @php
   $search = request()->query('search') ?: null;
   $rows = request()->query('rows') ?: 10;
   $filter = request()->query('filter') ?: null;
   $from = request()->query('from') ?: null;
   $to = request()->query('to') ?: null;
   @endphp
   @section('content')
 <div class="container-fluid">
    <br/>
    <!-- Basic Layout -->
    <form action="{{ route('admin.expenses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <h5 class="card-header">اضافة مصروف جديد</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-5">
                                <label class="form-label" for="basic-default-fullname">اسم بند المصروف </label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="name" value="{{ old('name') }}" required />
                                @error('name')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                          <div class="mb-3 col-md-5">
                                <label class="form-label" for="basic-default-company"> المبلغ</label>
                                <input type="number" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="price" value="{{ old('price') }}" required />
                                @error('price')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">اضافة صنف</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card mb-4">
        <div class="card">
            {{-- <h5 class="card-header">عرض الاصناف</h5> --}}
            <div class="card-header py-3 ">
                   <form id="filter-data" method="get" class=" justify-content-between">
                    <div class="d-flex justify-content-between" style="">
                        <div class="nav-item date_from_to_filter d-flex align-items-center m-2">
                            <label style="color: #636481;">من:</label><br>
                            <input type="date" onchange="document.getElementById('filter-data').submit()" class=" form-control" placeholder="من ...." @isset($from) value="{{ $from }}" @endisset id="from" name="from"/>&ensp;
                                <label style="color: #636481;">الي:</label><br>
                            <input type="date" onchange="document.getElementById('filter-data').submit()" class=" form-control" placeholder="الي ...." @isset($to) value="{{ $to }}" @endisset id="to" name="to"/>
                        </div>
                        <div class="nav-item d-flex align-items-center m-2">
                            <label style="padding: 0px 5px;color: #636481;">المعروض</label>
                            <select name="rows" onchange="document.getElementById('filter-data').submit()" id="largeSelect" class="form-select form-select-sm">
                                    <option >10</option>
                                    <option value="50" @isset($rows) @if ($rows=='50' ) selected @endif @endisset>50</option>
                                    <option value="100" @isset($rows) @if ($rows=='100' ) selected @endif @endisset> 100</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr class="table-dark">
                            <th>كود المصروف </th>
                            <th>البند</th>
                            <th>المبلغ</th>
                            <th>التاريخ</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($expenses as $expense)
                            <tr class="table-light">
                                <td>{{ $expense->id }}</td>
                                <td>{{ $expense->name }}</td>
                                <td>{{formate_price($expense->price) }}</td>
                                <td>{{$expense->created_at }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="crud edit-expense" data-expense-id="{{ $expense->id }}">
                                            <i class="fas fa-edit text-primary"></i>
                                        </a>
                                        <form  method="post" action="{{ route('admin.expenses.destroy', $expense->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a class="delete-item crud" data-expense-id="{{ $expense->id }}">
                                                <i class="fas fa-trash-alt  text-danger"></i>
                                            </a>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <br/><br/>
            <div class="d-flex flex-row justify-content-center">
                {{ $expenses->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
@push('style')
    <style>
        @media (max-width: 768px) {
            .date_from_to_filter{
                flex-wrap: wrap !important;
            }
        }
    </style>
@endpush
@push('script')
<script>
    jQuery('.edit-expense').click(function(){
        let data_edit = jQuery(this).attr('data-expense-id');
        let Popup = jQuery('#modalCenter').modal('show');
        let url = "{{ route('admin.expenses.edit',':id') }}";
        url = url.replace(':id',data_edit);
        $.ajax({
            url:url,
            type:"GET",
            success: function(data){
                if(data.status == true){
                    jQuery('#modal-content-inner').html(data.view);
                }
                console.log(data);
            }
        })
        console.log(Popup);
    });

    jQuery('.delete-item').click(function(){
        let expense_id = jQuery(this).attr('data-expense-id');
        if(confirm('هل متأكد من اتمام حذف الصنف رقم '+ expense_id)){
            jQuery(this).parents('form').submit();
        }
    });
</script>
@endpush
