@extends('Theme_2.layouts.master')

@section('content')
    <div class="container-fluid">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">فاتورة جديدة</h4>
        <!-- Basic Layout -->
        @if (flash()->message)
            <div class="{{ flash()->class }}">
                {{ flash()->message }}
            </div>

            @if (flash()->level === 'error')
                This was an error.
            @endif
        @endif
        <form action="{{ route('admin.orders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-9">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company">كود الفاتورة</label>
                                <input type="text" value="{{ generateOrderNumber() }}" class="form-control" placeholder=""
                                    name="order_number" required readonly/>
                            </div>
                            <div class="mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-country">
                                    اسم العميل</label>
                                <select type="text" id="selectCustomer" name="customer_id" class="form-control form-select2" required>
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
                            </div>
                            <div class="mb-3">
                                <table class="table table-bordered container-table">
                                    <tbody id="dynamicTable">
                                        <tr class="dynamic-added">
                                            <td>
                                                <div class="mb-3 select-product">
                                                    <label class="form-label" for="basic-default-company"> اسم الصنف</label>
                                                    <select type="text" name="addmore[0][product_id]" class="form-control form-select2 selectProduct" required>
                                                        <option>الصنف</option>
                                                        @foreach ($products as $product)
                                                            <option value={{ $product->id }}>{{ $product->name }} ( {{ $product->stock->quantity }} ) </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-3">
                                                    <label class="form-label" for="basic-default-company"> الكمية</label>
                                                    <input type="number"  class="form-control qty" placeholder=""
                                                        name="addmore[0][qty]" value="{{ old('addmore[0][qty]') }}" step=".01" required />
                                                    @error('addmore[0][qty]')
                                                        <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-3">
                                                    <label class="form-label" for="basic-default-company"> سعر الوحدة</label>
                                                    <input type="text" class="form-control price" placeholder=""
                                                        name="addmore[0][price]" value="{{ old('price[]') }}" required  />

                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-3">
                                                    <label class="form-label" for="basic-default-company"> سعر اجمالى</label>
                                                    <strong class="total-item">0</strong>
                                                    <br/>
                                                    جنيه
                                                </div>
                                            </td>
                                            <td>
                                                <div class="mb-3">
                                                    <input type="hidden" class="purchasing_price" name="purchasing_price" />
                                                    <label class="form-label" for="basic-default-company"> معدل الربح</label>
                                                    <strong class="profit-item">0</strong>
                                                    <br/>
                                                    جنيه
                                                </div>
                                            </td>
                                            <td>
                                               
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <div class="">
                                                    <button type="button" name="add" id="add"
                                                        class="btn btn-success btn-sm"> اضافة صنف اخر</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">اجمالى الفاتورة</td>
                                            <td colspan="2"><strong class="invoice-final-result">0</strong> جنيه</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company"> خصم على الفاتورة</label>
                                <input type="text" class="form-control" id="discount" placeholder="" name="discount"
                                    value="{{ old('discount') ?: 0 }}" required />
                                @error('discount')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <ul class="list-invoices">
                                    <li>
                                        <strong>اجمالى الفاتورة :</strong>
                                        <strong>
                                            <span class="invoice-final-result">{{ '0' }}</span>
                                            <span>جنية</span>
                                        </strong>
                                    </li>
                                    <li>
                                        <strong>خصم على الفاتورة :</strong>
                                        <strong>
                                            <span class="invoice-discount">{{ '0' }}</span>
                                            <span>جنية</span>
                                        </strong>
                                    </li>
                                    <li>
                                        <strong>السعر النهائي : </strong>
                                        <strong>
                                            <span class="invoice-due">{{ '0' }}</span>
                                            <span>جنية</span>
                                        </strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> طريقة الدفع</label>
                                    <select class="form-control" id="TypePayment" name="payment_type" required>
                                        <option value="cashe">كاش</option>
                                        <option value="postponed">أجل</option>
                                    </select>
                                </div>
                                <div class="mb-3 new-payment" style="display: none">
                                    <label class="form-label" for="basic-default-company">اضافة دفعة من الفاتورة</label>
                                    <input type="text" class="form-control" placeholder=""
                                    name="payment_value" value="0" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">اضافة الفاتورة</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('script')
    <script type="text/javascript">
        jQuery('#selectCustomer').on('change', function() {
            let customer_id = jQuery(this).val();
            let url = "{{ route('admin.ajax_get_customer_info', ':id') }}";
            url = url.replace(':id', customer_id);
            jQuery.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response != null) {
                        $('#customerphone').val(response.phone);
                    }
                }
            });
        });

        jQuery('table').on('change','.selectProduct',function() {
            let self = this;
            let product_id = jQuery(this).val();
            let url = "{{ route('admin.ajax_get_product_info', ':id') }}";
            url = url.replace(':id', product_id);
            jQuery.ajax({
                url: url,
                type: 'GET',
                success: async function(response) {
                    if (response != null) {
                        jQuery(self).parents('tr').find('input.qty').val(1);
                        jQuery(self).parents('tr').find('input.qty').attr('max',response.product.stock.quantity);
                        jQuery(self).parents('tr').find('input.price').val(response.product.stock.sale_price);
                        jQuery(self).parents('tr').find('.total-item').html(response.product.stock.sale_price * 1);
                        jQuery(self).parents('tr').find('.profit-item').html(Number(response.product.stock.sale_price) - Number(response.product.stock.purchasing_price));
                        jQuery(self).parents('tr').find('input.purchasing_price').val(Number(response.product.stock.purchasing_price));
                        console.log(response);
                        await CalculateTotals();
                    }
                    //console.log(response);
                }
            });
        });

        jQuery('table').on('keyup','input.qty',function(){
            let quantity = jQuery(this).parents('tr').find('input.qty').val() || 1;
            let price    = jQuery(this).parents('tr').find('input.price').val();
            let purchasing_price    = jQuery(this).parents('tr').find('input.purchasing_price').val();
            jQuery(this).parents('tr').find('.total-item').html(Number(price) * Number(quantity));
            jQuery(this).parents('tr').find('.profit-item').html((Number(price) - Number(purchasing_price)) * quantity);
            CalculateTotals();
        });

        jQuery('table').on('keyup','input.price',function(){
            let quantity = jQuery(this).parents('tr').find('input.qty').val() || 1;
            let price    = jQuery(this).parents('tr').find('input.price').val();
            let purchasing_price    = jQuery(this).parents('tr').find('input.purchasing_price').val();
            jQuery(this).parents('tr').find('.total-item').html(Number(price) * Number(quantity));
            jQuery(this).parents('tr').find('.profit-item').html((Number(price) - Number(purchasing_price)) * quantity);
            CalculateTotals();
        });

        jQuery('body').on('keyup','#discount',function(){
            CalculateTotals();
        });



        jQuery("#add").on('click',function() {
            let products = {!! json_encode($products) !!};
            let count_tr = jQuery('.container-table tr').length;
            let tr       = jQuery('.dynamic-added').html();
            let options  = "<option>الصنف</option>";
            jQuery('#dynamicTable').append(`<tr class="tr${count_tr}">${tr}</tr>`);
            jQuery(`.tr${count_tr}`).find('select').attr('name',`addmore[${count_tr}][product_id]`);
            jQuery(`.tr${count_tr}`).find('select').addClass('new-selet2');
            jQuery(`.tr${count_tr}`).find('.qty').attr('name',`addmore[${count_tr}][qty]`);
            jQuery(`.tr${count_tr}`).find('.price').attr('name',`addmore[${count_tr}][price]`);
            jQuery(`.tr${count_tr}`).find('td:last-child').html(`<button type="button" class="btn btn-danger btn-sm remove-tr">-</button>`);
            jQuery(`.tr${count_tr}`).find('.total-item').html("0");
            products.forEach(function(product){
                options +=`<option value="${product.id}">${product.name} (${product.stock.quantity}) </option>`;
            });
            jQuery(`.tr${count_tr}`).find('.select-product').html(`
                <label class="form-label" for="basic-default-company"> اسم المنتج</label>
                <select type="text" name="addmore[${count_tr}][product_id]"
                    class="form-control form-select-new selectProduct" required>
                    ${options}
                </select>
            `);
            jQuery('.form-select-new').select2();
        });

        function CalculateTotals(){
            let totals = 0;
            let all_totals = document.querySelectorAll('table .total-item').forEach(function(item){
                let number_value = Number(jQuery(item).html());
                totals+=number_value;
            });

            jQuery('.invoice-final-result').html(totals);

            let discount = jQuery('#discount').val() || 0;
            jQuery('.invoice-discount').html(Number(discount));
            jQuery('.invoice-due').html(Number(totals) - Number(discount));
        }

        $('table').on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            CalculateTotals();
        });

        jQuery('#TypePayment').on('change',function(){
            let value = $(this).val();
            if(value == 'postponed'){
                jQuery('.new-payment').fadeIn(100);
            } else {
                jQuery('.new-payment').fadeOut(100);
            }
        });
    </script>
@endpush


@push('style')
<style>
    .list-invoices{
        list-style: none;
    }
    .list-invoices li
    {
        padding: 13px;
        display: flex;
        justify-content: space-between;
    }
    @media(max-width:1000px){
        table tr {
            display: grid;
        }
        table tr.dynamic-added td .mb-3{
            margin-bottom: 0px !important;
        }
    }
</style>
@endpush
