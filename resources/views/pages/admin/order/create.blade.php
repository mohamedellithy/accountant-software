@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">طلب جديد </h4>
        <!-- Basic Layout -->
        @if (flash()->message)
            <div class="{{ flash()->class }}">
                {{ flash()->message }}
            </div>

            @if (flash()->level === 'error')
                This was an error.
            @endif
        @endif
        <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-10">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-country">

                                    اسم الزبون</label>
                                <select type="text" id="selectBox" name="customer_id" class="form-control" required>
                                    <option value=""></option>
                                    @foreach ($customers as $customer)
                                        <option value={{ $customer->id }}>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company"> رقم الجوال</label>
                                <input type="text" class="form-control" id="customerphone" placeholder=""
                                    name="customerphone" value="" required />
                                {{-- @error('phone')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror --}}
                            </div>
                            <table class="table table-bordered" id="dynamicTable">
                                <tr class="dynamic-added">
                                    <td>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-company"> اسم المنتج</label>
                                            <select type="text" id="product_id" name="addmore[0][product_id]"
                                                class="form-control" required>
                                                @foreach ($products as $product)
                                                    <option value={{ $product->id }}>{{ $product->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-company"> الكمية</label>
                                            <input type="text" class="form-control" id="qty" placeholder=""
                                                name="addmore[0][qty]" value="{{ old('addmore[0][qty]') }}" required />
                                            @error('addmore[0][qty]')
                                                <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-company"> السعر</label>
                                            <input type="text" class="form-control" id="price" placeholder=""
                                                name="addmore[0][price]" value="{{ old('price[]') }}" required  />

                                        </div>
                                    </td> --}}

                                    <td>
                                        <div class="mt-4">
                                            <button type="button" name="add" id="add"
                                                class="btn btn-success">Add</button>
                                        </div>
                                    </td>


                                </tr>
                            </table>

                            <div class="mb-3">
                                <p>الاجمالي: </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company"> التخفيض</label>
                                <input type="text" class="form-control" id="discount" placeholder="" name="discount"
                                    value="{{ old('discount') }}" required />
                                @error('discount')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <p>الاجمالي بعد التخفيض:</p>
                            </div>

                            <button type="submit" class="btn btn-primary">اضافة الطلب</button>
                        </div>
                    </div>
                </div>

        </form>
    </div>
@endsection
@push('script')
    <script type="text/javascript">
        $('#selectBox').on('change', function() {
            let id = $(this).val();
            let url = '{{ route('getPhone', ':id') }}';
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    if (response != null) {
                        $('#customerphone').val(response.phone);
                    }
                }
            });
        });

        var i = 0;

        $("#add").click(function() {

            ++i;

            $("#dynamicTable").append(
                '<tr class="dynamic-added"><td><select type="text" id="product_id" name="addmore[' + i +
                '][product_id]" class="form-control" required>' +
                ' @foreach ($products as $product)' + '" <option value="' +
                '{{ $product->id }}' + '">' + '{{ $product->name }}' + '</option> ' +
                '@endforeach' + ' </select> ' +
                '</td><td><input type="text" name="addmore[' + i +
                '][qty]" placeholder="" class="form-control name_list"/></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>'
            );
        });



        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });

        ;
    </script>
@endpush
