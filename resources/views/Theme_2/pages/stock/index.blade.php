 @extends('Theme_2.layouts.master') @php $search = request()->query('search') ?: null; $rows = request()->query('rows') ?: 10; $filter = request()->query('filter') ?: null; @endphp @section('content')
 <div class="container-fluid">
    <br/>
    <!-- Basic Layout -->
    <form action="{{ route('admin.stocks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <h5 class="card-header">اضافة صنف جديد</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="formtabs-country">
                                    اسم الصنف</label>
                                <select name="product_id" class="form-select2 form-control"
                                    data-allow-clear="true" required>
                                    @foreach($products as $product)
                                        <option value={{ $product->id }}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="basic-default-company"> الكمية</label>
                                <input type="number" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="quantity" value="{{ old('quantity') }}" required />
                                @error('quantity')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label" for="basic-default-company"> سعر الشراء ( الوحدة / الكيلو ) </label>
                                <input type="number" step="0.1" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="purchasing_price" value="{{ old('purchasing_price') }}" required />
                                @error('purchasing_price')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-12 col-md-4">
                                <label class="form-label" for="basic-default-company"> سعر البيع ( الوحدة / الكيلو ) </label>
                                <input type="number" step="0.1" class="form-control" id="basic-default-fullname" placeholder=""
                                    name="sale_price" value="{{ old('sale_price') }}" required />
                                @error('sale_price')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label"  for="formtabs-country">
                                    اسم المورد</label>
                                <select name="supplier_id" id="formtabs-country" class="form-select2 form-control"
                                    data-allow-clear="true" required>
                                    @foreach($suppliers as $supplier)
                                        <option value={{ $supplier->id }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">اضافة صنف للمخزن</button>
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
            <h5 class="card-header">عرض الاصناف</h5>
            <div class="card-header py-3 ">
                <form id="filter-data" method="get" class="d-flex justify-content-between">
                    <div class="mb-3 col-12 col-md-4">
                        <label class="form-label" for="formtabs-country">اسم الصنف</label>
                        <select name="filter[product_id]" onchange="document.getElementById('filter-data').submit()" class="form-select2 form-control"
                            data-allow-clear="true">
                            <option value="">الكل</option>
                            @foreach($products as $product)
                                <option value={{ $product->id }} @isset($filter['product_id']) @if ($filter['product_id'] == $product->id) selected @endif
                                    @endisset>{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-12 col-md-4">
                        <label class="form-label"  for="formtabs-country">اسم المورد</label>
                        <select name="filter[supplier_id]" id="formtabs-country" onchange="document.getElementById('filter-data').submit()" class="form-select2 form-control"
                            data-allow-clear="true">
                            <option value="">الكل</option>
                            @foreach($suppliers as $supplier)
                                <option value={{ $supplier->id }} @isset($filter['supplier_id']) @if ($filter['supplier_id'] == $supplier->id) selected @endif
                                    @endisset>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex">
                        <div class="nav-item d-flex align-items-center m-2">
                            <select name="filter[price]" id="largeSelect" onchange="document.getElementById('filter-data').submit()" class="form-control">
                                 <option>فلتر الاصناف</option>
                                 <option value="high-price" @isset($filter['price']) @if ($filter['price']=='high-price' ) selected @endif
                                     @endisset>
                                     الاعلي سعرا</option>
                                 <option value="low-price" @isset($filter['price']) @if ($filter['price']=='low-price' ) selected @endif
                                     @endisset>
                                     الاقل سعرا</option>

                             </select>
                        </div>
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
                @if($statics_for_product)
                    <table class="table table-static table-bordered">
                        <tbody>
                            <tr>
                                <th>الصنف</th>
                                <td>{{ $statics_for_product?->name }}</td>
                                <th>اجمالي المخزن</th>
                                <td>{{ $statics_for_product?->total_qty ?: 0 }} (وحدة / كيلو)</td>
                                <th>اجمالي تكلفة الشراء</th>
                                <td>{{ $statics_for_product?->total_cost_purchasing ?: 0 }}</td>
                                <th>اجمالي تكلفة البيع</th>
                                <td>{{ $statics_for_product?->total_cost_sale ?: 0 }}</td>
                                <th>اجمالي الربح المتوقع</th>
                                <td>{{ ($statics_for_product?->total_cost_sale ?: 0) - ($statics_for_product?->total_cost_purchasing ?: 0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endif
                <table class="table">
                    <thead class="table-light">
                        <tr class="table-dark">
                            <th>كود الصنف</th>
                            <th>الاسم</th>
                            <th>الكمية ( الوحدة / الكيلو ) </th>
                            <th>سعر البيع ( الوحدة / الكيلو) </th>
                            <th>سعر الشراء ( الوحدة / الكيلو) </th>
                            <th>قيمة الربح </th>
                            <th>اسم المورد </th>
                            <th>تاريخ تحديث الصنف</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($stocks as $stock)
                            <tr class="table-light">
                                <td>{{ $stock->product->id }}</td>
                                <td>{{ $stock->product->name }}</td>
                                <td>{{ $stock->quantity }}</td>
                                <td>{{ formate_price($stock->sale_price) }}</td>
                                <td>{{ formate_price($stock->purchasing_price) }}</td>
                                <td>{{ formate_price($stock->sale_price - $stock->purchasing_price) }}</td>
                                <td>
                                @if($stock->supplier)
                                    {{ $stock->supplier->name }}
                                    <a class="crud" href="{{ route('admin.suppliers.show', $stock->supplier->id) }}">
                                        <i class="far fa-eye"></i>
                                    </a>
                                @endif
                                </td>
                                <td>{{ date('Y-m-d',strtotime($stock->updated_at)) }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="crud edit-stock" data-stock-id="{{ $stock->id }}">
                                            <i class="fas fa-edit text-primary"></i>
                                        </a>
                                        <form  method="post" action="{{ route('admin.stocks.destroy', $stock->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a class="delete-item crud" data-stock-id="{{ $stock->id }}">
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
                {{ $stocks->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    jQuery('.edit-stock').click(function(){
        let data_edit = jQuery(this).attr('data-stock-id');
        let Popup = jQuery('#modalCenter').modal('show');
        let url = "{{ route('admin.stocks.edit',':id') }}";
        url = url.replace(':id',data_edit);
        $.ajax({
            url:url,
            type:"GET",
            success: function(data){
                if(data.status == true){
                    jQuery('#modal-content-inner').html(data.view);
                   // jQuery('.form-select2').select2();
                }
                console.log(data);
            }
        });
    });

    jQuery('.delete-item').click(function(){
        let stock_id = jQuery(this).attr('data-stock-id');
        if(confirm('هل متأكد من اتمام حذف الصنف رقم '+ stock_id)){
            jQuery(this).parents('form').submit();
        }
    });
</script>
@endpush
