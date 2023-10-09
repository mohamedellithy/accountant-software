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
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mb-3 w-100 ">
                                    <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-country">
                                        اسم الزبون</label>
                                    <select type="text" id="selectBox" name="customer_id" class="form-control w-50"
                                        required>
                                        <option value=""></option>
                                        @foreach ($customers as $customer)
                                            <option value={{ $customer->id }}>{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                    @enderror

                                </div>
                                <div class="mb-3 w-100">
                                    <label class="form-label" for="basic-default-company"> رقم الجوال</label>
                                    <input type="text" class="form-control w-50" id="customerphone" placeholder=""
                                        name="customerphone" value="" required />
                                    {{-- @error('phone')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror --}}
                                </div>
                            </div>
                            <table class="table table-bordered container-table" id="dynamicTable">
                                <tr class="dynamic-added tr0">
                                    <td class="w-25">
                                        <div class="mb-3 ">
                                            <label class="form-label" for="basic-default-company"> اسم المنتج</label>
                                            <select type="text" name="addmore[0][product_id]"
                                                class="form-control product_id" id="product_id0" required>
                                                <option value=""></option>
                                                @foreach ($products as $product)
                                                    <option value={{ $product->id }}>{{ $product->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-company"> الكمية</label>
                                            <input type="text" class="form-control qty" placeholder=""
                                                name="addmore[0][qty]" value="{{ old('addmore[0][qty]') }}" required
                                                oninput="getTotalQty()" />
                                            @error('addmore[0][qty]')
                                                <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-company"> السعر</label>
                                            <input type="text" class="form-control originprice" placeholder=""
                                                name="originprice0" readonly />

                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-company"> السعر بعد التخفيض</label>
                                            <input type="text" class="form-control price" placeholder=""
                                                name="addmore[0][price]" value="{{ old('price[]') }}" required
                                                oninput="getTotalPrice()" />

                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-company"> اجمالي</label>
                                            <input type="text" class="form-control subtotal" placeholder=""
                                                name="subtotal0" readonly />

                                        </div>
                                    </td>
                                    <td>
                                        <div class="mt-4">
                                            <button type="button" name="add" id="add" class="btn btn-success"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                    </td>
                                </tr>

                            </table>
                            <table class="table table-borderless">
                                <tr class="sum-info">
                                    <td class=" w-25">
                                        <div class="mb-3">

                                            <label class="form-label" for="basic-default-company"> المجموع</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-company"> اجمالي الكميات </label>
                                            <p id="total-qty" class="bg-light"></p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-company"> اجمالي السعر </label>
                                            <p id="total-origin-price" class="bg-light"></p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-3">
                                            <label class="form-label" for="basic-default-company"> اجمالي السعر بعد التخفيض
                                            </label>
                                            <p id="total-price" class="bg-light"></p>
                                        </div>
                                    </td>

                                </tr>
                            </table>
                            <div class="mb-3 d-flex">
                                <p class="font-weight-bold"> الاجمالي :</p>
                                <p id="total" class="bg-light"> </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company"> التخفيض</label>
                                <input type="text" class="form-control w-25" id="discount" placeholder=""
                                    name="discount" value="{{ old('discount') }}" oninput="getFinalTotal()" />
                                @error('discount')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3 w-25 d-flex">
                                <p class="font-weight-bold"> الاجمالي بعد التخفيض:</p>
                                <p id="totalAfterDiscount" class="bg-light "></p>
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

        jQuery("#add").on('click', function() {
            let count_tr = jQuery('.container-table tr').length;
            let tr = jQuery('.dynamic-added').html();
            jQuery('#dynamicTable').append(`<tr class="tr${count_tr}">${tr}</tr>`);
            jQuery(`.tr${count_tr}`).find('select').attr('name', `addmore[${count_tr}][product_id]`);
            jQuery(`.tr${count_tr}`).find('.originprice').attr('name', `originprice${count_tr}`);
            jQuery(`.tr${count_tr}`).find('.subtotal').attr('name', `subtotal${count_tr}`);
            jQuery(`.tr${count_tr}`).find('.qty').attr('name', `addmore[${count_tr}][qty]`);
            jQuery(`.tr${count_tr}`).find('.price').attr('name', `addmore[${count_tr}][price]`);
            jQuery(`.tr${count_tr}`).find('td:last-child').html(
                `<button type="button" class="btn btn-danger remove-tr mt-4"><i class="fas fa-trash-alt "></i></button>`
            );

        });



        $('table').on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            getTotalQty()
            getTotalPrice()
            calculateTotal($(this));
            calculateTotal2($(this));
            getOriginPriceTotal($(this));
        });


        $(document).ready(function() {

            $('table').on('change', '.product_id', function() {
                var selectedProductId = $(this).val();
                var originPriceInput = $(this).closest('tr').find('.originprice');
                $.ajax({
                    url: '/getProductPrice/' + selectedProductId,
                    type: 'GET',
                    success: function(data) {

                        originPriceInput.val(data.price);
                    },
                    error: function() {
                        // Handle error
                    }
                });

            });


        });



        function getTotalQty() {
            var sum = 0;
            $('.qty').each(function() {
                var item_val = parseFloat($(this).val());
                if (isNaN(item_val)) {
                    item_val = 0;
                }
                sum += item_val;
                $('#total-qty').text(sum);
            });
        }

        function getTotalPrice() {
            var sum = 0;
            $('.price').each(function() {
                var item_val = parseFloat($(this).val());
                if (isNaN(item_val)) {
                    item_val = 0;
                }
                sum += item_val;
                $('#total-price').text(sum);
            });

        }
        $('table').on('input', '.qty, .price', function() {

            calculateTotal($(this));
            calculateTotal2($(this));
            getOriginPriceTotal($(this));
        });

        function calculateTotal(element) {
            const row = element.closest('tr');
            const quantity = parseFloat(row.find('.qty').val());
            const price = parseFloat(row.find('.price').val());

            if (!isNaN(quantity) && !isNaN(price)) {
                const total = quantity * price;
                row.find('.subtotal').val(total);
            } else {
                row.find('.subtotal').val('');
            }
        }

        function calculateTotal2(element) {
            var sum = 0;
            $('.subtotal').each(function() {
                var item_val = parseFloat($(this).val());
                if (isNaN(item_val)) {
                    item_val = 0;
                }
                sum += item_val;
                $('#total').text(sum);
                console.log(sum)
            })
        };

        function getOriginPriceTotal(element) {
            var sum = 0;
            $('.originprice').each(function() {
                var item_val = parseFloat($(this).val());
                if (isNaN(item_val)) {
                    item_val = 0;
                }
                sum += item_val;
                $('#total-origin-price').text(sum);
                console.log(sum)
            })
        };

        function getFinalTotal() {
            let total = document.getElementById("total").innerHTML;
            let discount = document.getElementById("discount").value;
            const finalTotal = parseFloat(total) - parseFloat(discount);
            if (isNaN(finalTotal)) {
                document.getElementById("totalAfterDiscount").textContent = 0;
            }

            document.getElementById("totalAfterDiscount").textContent = finalTotal;

        }
    </script>
@endpush
