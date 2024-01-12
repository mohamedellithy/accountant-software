@extends('Theme_2.layouts.master')

@section('content')
    <div class="container-fluid">
        <h4 class="fw-bold py-3" style="padding-bottom: 0rem !important;">تعديل فاتوره</h4>
        <!-- Basic Layout -->
        @if (flash()->message)
            <div class="{{ flash()->class }}">
                {{ flash()->message }}
            </div>

            @if (flash()->level === 'error')
                This was an error.
            @endif
        @endif
        <form action="{{ route('admin.purchasing-invoices.update',$order->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-company">كود الفاتورة</label>
                                <input type="text" value="{{ $order->order_number }}" class="form-control" placeholder=""
                                    name="order_number"/>
                            </div>
                            <div class="mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-country">
                                    اسم الزبون</label>
                                <select type="text" name="supplier_id" class="form-control form-select2" required>
                                    <option value=""></option>
                                    @foreach ($suppliers as $supplier)
                                        <option value={{ $supplier->id }} @if($order->supplier_id == $supplier->id) selected @endif>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <table class="table table-bordered container-table">
                                    <tbody id="dynamicTable">
                                        @foreach($order->invoice_items as $item)
                                            <tr class="dynamic-added">
                                                <td>
                                                    <div class="mb-3 select-product">
                                                        <label class="form-label" for="basic-default-company"> اسم المنتج</label>
                                                        <select type="text" name="addmore[{{ $loop->index }}][product_id]"
                                                            class="form-control form-select2 selectProduct" required>
                                                            <option value=""></option>
                                                            @foreach ($products as $product)
                                                                <option value={{ $product->id }} @if($item->product_id == $product->id) selected @endif>{{ $product->name }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-default-company"> الكمية</label>
                                                        <input type="number"  class="form-control qty" placeholder=""
                                                            name="addmore[{{ $loop->index }}][qty]" value="{{ $item->qty ?: old('addmore[0][qty]') }}" step=".01" required />
                                                        @error('addmore[{{ $loop->index }}][qty]')
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
                                                        <strong class="total-item">{{ $item->price * $item->qty }}</strong>
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
                                            <td colspan="2"><strong class="invoice-final-result">{{ $order->sub_total }}</strong> جنيه</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-company"> طريقة الدفع</label>
                                    <select class="form-control" id="TypePayment" name="payment_type" required>
                                        <option value="cashe"     @if($order->payment_type == 'cashe') selected @endif>كاش</option>
                                        <option value="postponed" @if($order->payment_type == 'postponed') selected @endif>أجل</option>
                                    </select>
                                </div>
                                <div class="mb-3 new-payment" @if($order->payment_type == 'cashe') style="display: none" @endif>
                                    <label class="form-label" for="basic-default-company">اضافة دفعة من الفاتورة</label>
                                    <input type="text" class="form-control" placeholder=""
                                    name="payment_value" value="0"  max="{{ $order->total_price - $order->invoice_payments()->sum('value') }}"/>
                                </div>
                            </div>
                            <div class="float-end">
                                <label class="form-label" for="basic-default-company" style="font-size:15px;" > تحديث المخزن</label>
                                <input
                                style="
                                width:15px;
                                height:15px;
                                position: absolute;
                                margin-top: 5px;
                                margin-right: 8px;"
                                type="checkbox" id="update_stock" name="update_stock" value="1" @if($order->update_stock == '1') checked @endif/>
                                    @error('update_stock')
                                    <span class="text-danger w-100 fs-6">{{ $message }}</span>
                                    @enderror
                            </div>
                            <br/><br/>
                            <div class="">
                                <button type="submit" class="btn btn-danger">تعديل الفاتورة</button>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-body" id="paymentsOrder">
                            <h5> الدفعات</h5>
                            <table class="table table-border table-payments" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="background-color:#eee;color:black !important">الدفعة</th>
                                        <th style="background-color:#eee;color:black !important">تاريخ الدفعة</th>
                                        <th style="background-color:#eee;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->invoice_payments as $payment)
                                        <tr>
                                            <td style="color:black !important">{{ formate_price($payment->value) }}</td>
                                            <td style="color:black !important">{{ $payment->created_at }}</td>
                                            <td style="color:black !important">
                                                <a href="{{ route('admin.supplier-payments-delete',['id' => $payment->id]) }}" class="btn btn-danger btn-sm">
                                                    <i class='bx bxs-x-circle' ></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('script')
    <script type="text/javascript">
        CalculateTotals();
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
                        jQuery(self).parents('tr').find('input.price').val(response.product.stock.sale_price);
                        jQuery(self).parents('tr').find('.total-item').html(response.product.stock.sale_price * 1);
                        console.log(response);
                        await CalculateTotals();
                    }
                }
            });
        });

        jQuery('table').on('keyup','input.qty',function(){
            let quantity = jQuery(this).parents('tr').find('input.qty').val() || 1;
            let price    = jQuery(this).parents('tr').find('input.price').val();
            jQuery(this).parents('tr').find('.total-item').html(Number(price) * Number(quantity));
            CalculateTotals();
        });

        jQuery('table').on('keyup','input.price',function(){
            let quantity = jQuery(this).parents('tr').find('input.qty').val() || 1;
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
            jQuery(`.tr${count_tr}`).find('.qty').attr('name',`addmore[${count_tr}][qty]`);
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
        table tr {
            display: grid;
        }
        table tr.dynamic-added td .mb-3{
            margin-bottom: 0px !important;
        }
    }
</style>
@endpush
