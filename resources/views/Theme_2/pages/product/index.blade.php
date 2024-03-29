 @extends('Theme_2.layouts.master') @php $search = request()->query('search') ?: null; $rows = request()->query('rows') ?: 10; $filter = request()->query('filter') ?: null; @endphp @section('content')
 <div class="container-fluid">
    <br/>
    <!-- Basic Layout -->
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <h5 class="card-header">اضافة صنف جديد</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-5">
                                <label class="form-label" for="basic-default-fullname">اسم الصنف</label>
                                <input type="text" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="name" value="{{ old('name') }}" required />
                                @error('name')
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
            <div class="card-header py-3">
                <form id="filter-data" method="get" class="d-flex justify-content-between">
                    <div class="nav-item d-flex align-items-center m-2" style="background-color: #eee;padding: 8px;">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input type="text" class="search form-control border-0 shadow-none" onblur="document.getElementById('filter-data').submit()" placeholder="البحث ...." @isset($search) value="{{ $search }}" @endisset id="search" name="search" style="background-color: #eee;"/>
                    </div>
                    <div class="d-flex">
                        <div class="nav-item d-flex align-items-center m-2">
                            <label style="padding: 0px 10px;color: #636481;">المعروض</label>
                            <select name="rows" onchange="document.getElementById('filter-data').submit()" id="largeSelect" class="form-select form-select-sm">
                                 <option>10</option>
                                 <option value="50" @isset($rows) @if ($rows=='50' ) selected @endif @endisset>
                                     50</option>
                                 <option value="100" @isset($rows) @if ($rows=='100' ) selected @endif @endisset>
                                     100</option>
                             </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr class="table-dark">
                            <th>كود الصنف</th>
                            <th>الاسم</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($products as $product)
                            <tr class="table-light">
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="crud" href="{{ route('admin.products.show',$product->id) }}">
                                            <i class="far fa-eye text-dark"></i>
                                        </a>
                                        <a class="crud edit-product" data-product-id="{{ $product->id }}">
                                            <i class="fas fa-edit text-primary"></i>
                                        </a>
                                        <form  method="post" action="{{ route('admin.products.destroy', $product->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a class="delete-item crud" data-product-id="{{ $product->id }}">
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
                {{ $products->onEachSide(2)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    jQuery('.edit-product').click(function(){
        let data_edit = jQuery(this).attr('data-product-id');
        let Popup = jQuery('#modalCenter').modal('show');
        let url = "{{ route('admin.products.edit',':id') }}";
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
        let product_id = jQuery(this).attr('data-product-id');
        if(confirm('هل متأكد من اتمام حذف الصنف رقم '+ product_id)){
            jQuery(this).parents('form').submit();
        }
    });
</script>
@endpush
