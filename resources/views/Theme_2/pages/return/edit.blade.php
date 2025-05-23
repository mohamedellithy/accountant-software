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
        <form action="{{ route('admin.returns.update',$customerReturn->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company">كود الفاتورة</label>
                                <input type="text" value="{{ $customerReturn->order_number ?: generateReturnOrderNumber() }}" class="form-control" placeholder=""
                                    name="order_number" />
                            </div>
                            <div class="mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-country">
                                    اسم الزبون</label>
                                <select type="text" name="customer_id" class="form-control form-select2" required>
                                    <option value=""></option>
                                    @foreach ($customers as $customer)
                                        <option value={{ $customer->id }} @if($customerReturn?->customer_id == $customer->id) selected @endif>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company"> رقم الجوال</label>
                                <input type="text" class="form-control" id="customerphone" placeholder=""
                                    name="customerphone" value="" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company">نوع الفاتورة</label>
                                <select name="type_return_bill" class="form-control">
                                    <option value="sale"       @if($customerReturn->type_return == 'sale') selected @endif>فاتورة البيع</option>
                                    <option value="purchasing" @if($customerReturn->type_return == 'purchasing') selected @endif>فاتورة الشراء</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <table class="table table-bordered container-table">
                                    <tbody id="dynamicTable">
                                        @foreach($customerReturn->returnitems as $item)
                                            <tr class="dynamic-added">
                                                <td>
                                                    <div class="mb-3 select-product">
                                                        <label class="form-label" for="basic-default-company"> اسم المنتج</label>
                                                        <select type="text" name="addmore[{{ $loop->index }}][product_id]"
                                                            class="form-control form-select2 selectProduct" required>
                                                            @foreach ($products as $product)
                                                                <option value={{ $product->id }} @if($item->product_id == $product->id) selected @endif>{{ $product->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-company"> الكمية</label>
                                                        <input type="number"  class="form-control quantity" placeholder=""
                                                            name="addmore[{{ $loop->index }}][quantity]" value="{{ $item->quantity ?: old('addmore[0][quantity]') }}" required />
                                                        @error('addmore[{{ $loop->index }}][quantity]')
                                                            <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-company"> سعر الوحدة</label>
                                                        <input type="text" class="form-control price" placeholder=""
                                                            name="addmore[{{ $loop->index }}][price]" value="{{ $item->price ?:  old('price[]') }}" required  />

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-company"> سعر اجمالى</label>
                                                        <strong class="total-item">{{ $item->price * $item->quantity }}</strong>
                                                        <br/>
                                                        جنيه
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="">
                                                        <button type="button" name="add"
                                                            class="btn btn-danger btn-sm remove-tr">-</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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
                                            <td colspan="2"><strong class="invoice-final-result">{{ $customerReturn->total_price }}</strong> جنيه</td>
                                        </tr>
                                    </tfoot>
                                </table>

                                       <div class="card mb-4">
                        <div class="card-body">

                            <div class="float-end">
                                <label class="form-label" for="basic-default-company" style="  font-size:20px;" > تحديث المخزن</label>
                                <input
                                style="
                                width:30px;
                                height:25px;
                                position: absolute;
                                margin-top: 5px;
                                margin-right: 8px;"
                                type="checkbox" id="update_stock" name="update_stock"value="1" />
                                    @error('update_stock')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="float-start">
                                <button type="submit" class="btn btn-danger">اضافة الفاتورة</button>
                            </div>

                        </div>
                    </div>


                            </div>

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
                        jQuery(self).parents('tr').find('input.quantity').val(1);
                        //jQuery(self).parents('tr').find('input.quantity').attr('max',response.product.stock.quantity);
                        jQuery(self).parents('tr').find('input.price').val(response.product.stock.sale_price);
                        jQuery(self).parents('tr').find('.total-item').html(response.product.stock.sale_price * 1);
                        console.log(response);
                        await CalculateTotals();
                    }
                }
            });
        });

        jQuery('table').on('keyup','input.quantity',function(){
            let quantity = jQuery(this).parents('tr').find('input.quantity').val() || 1;
            let price    = jQuery(this).parents('tr').find('input.price').val();
            jQuery(this).parents('tr').find('.total-item').html(Number(price) * Number(quantity));
            CalculateTotals();
        });

        jQuery('body').on('keyup','#discount',function(){
            CalculateTotals();
        });



        jQuery("#add").on('click',function() {
            let products = {!! json_encode($products) !!};
            let count_tr = jQuery('.container-table tr').length;
            let tr       = jQuery('.dynamic-added').html();
            let options  = "";
            jQuery('#dynamicTable').append(`<tr class="tr${count_tr}">${tr}</tr>`);
            jQuery(`.tr${count_tr}`).find('select').attr('name',`addmore[${count_tr}][product_id]`);
            jQuery(`.tr${count_tr}`).find('.quantity').attr('name',`addmore[${count_tr}][quantity]`);
            jQuery(`.tr${count_tr}`).find('.price').attr('name',`addmore[${count_tr}][price]`);
            jQuery(`.tr${count_tr}`).find('td:last-child').html(`<button type="button" class="btn btn-danger btn-sm remove-tr">-</button>`);
            jQuery(`.tr${count_tr}`).find('.total-item').html("0");

            products.forEach(function(product){
                options +=`<option value="${product.id}">${product.name}</option>`;
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
            let tr_lenght = jQuery('#dynamicTable tr').length;
            if(tr_lenght <= 2){
                return;
            }
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
        .select2-container{
            width: 100% !important;
        }
        table tr {
            display: grid;
        }
        table tr.dynamic-added td .mb-3{
            margin-bottom: 0px !important;
        }
        #update_stock{
            width: 16px !important;
        }
    }
</style>
@endpush
