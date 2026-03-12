<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\StakeHolder;
use Illuminate\Http\Request;
use App\Models\CustomerPayment;
use App\Models\SupplierPayment;
use Illuminate\Support\Facades\DB;
use App\Models\DiscountOnStackHolder;


class PaymentsController extends Controller
{
    /**
     * تم إعطاء أحد العملاء مبلغ 5000 ﷼ كسلفة
     * .(credit) هنا المؤسسة تعتبر دائن
     *  (debit)  والعميل هو المدين
     * . لذلك الدائن هو المال الممنوح من قبل المنشأة.
     */

    public function supplier_payments(Request $request){
        $suppliers = StakeHolder::query();

        $suppliers = $suppliers->where('role','supplier')->where(function($query){
            $query->whereHas('orders')->orWhereHas('purchasing_invoices');
        })->withSum('orders','total_price')
        ->withSum('customer_payments','value')
        ->withSum('supplier_payments','value')
        ->withSum('purchasing_invoices','total_price');

        $suppliers->when(request('search') != null, function ($q) {
            return $q->where('name', 'like', '%' . request('search') . '%');
        });

        $suppliers->when(request('filter') == 'sort_asc', function ($q) {
            return $q->orderBy('created_at', 'asc');
        },function ($q) {
            return $q->orderBy('created_at', 'desc');
        });

        if ($request->has('rows')):
            $per_page = $request->query('rows');
        endif;

        $suppliers = $suppliers->paginate(10);
        return view(config('app.theme').'.pages.payment.supplier-payments', compact('suppliers'));
    }

    public function customer_payments(Request $request){
        $customers = StakeHolder::query();

        $customers = $customers->where('role','customer')->whereHas('orders')->orWhereHas('purchasing_invoices')->withSum('orders','total_price')
        ->withSum('customer_payments','value')
        ->withSum('supplier_payments','value')
        ->withSum('purchasing_invoices','total_price');

        $customers->when(request('search') != null, function ($q) {
            return $q->where('name', 'like', '%' . request('search') . '%');
        });

        $customers->when(request('filter') == 'sort_asc', function ($q) {
            return $q->orderBy('created_at', 'asc');
        },function ($q) {
            return $q->orderBy('created_at', 'desc');
        });

        if ($request->has('rows')):
            $per_page = $request->query('rows');
        endif;

        $customers = $customers->paginate(10);
        return view(config('app.theme').'.pages.payment.customer-payments', compact('customers'));
    }

    public function customer_payments_lists($id){
        $customer = StakeHolder::find($id);
        $customer_payments = CustomerPayment::where('customer_id',$id)
        ->select(
            'id',
            'customer_id as user_id',
            's_invoice_id as invoice_id',
            'value',
            'description',
            DB::raw("'for_sales'as model_type"),
            'created_at'
        );
        $supplier_payments = SupplierPayment::where('supplier_id',$id)
        ->select(
            'id',
            'supplier_id as user_id',
            'p_invoice_id as invoice_id',
            'value',
            'description',
            DB::raw("'for_purchasing'as model_type"),
            'created_at'
        );
        $discounts = DiscountOnStackHolder::where('user_id',$id)
        ->select(
            'id',
            'user_id',
            DB::raw('NULL as invoice_id'),
            'value',
            'description',
            DB::raw("'for_discounts'as model_type"),
            'created_at'
        );
        $payments = $customer_payments->unionAll($supplier_payments)
        ->unionAll($discounts)
        ->orderBy('created_at','desc')
        ->paginate(20);
        return view(config('app.theme').'.pages.customer.payments', compact('payments','customer'));
    }

    public function supplier_payments_lists($id){
        $supplier = StakeHolder::find($id);
        $customer_payments = CustomerPayment::where('customer_id',$id)
        ->select(
            'id',
            'customer_id as user_id',
            's_invoice_id as invoice_id',
            'value',
            'description',
            DB::raw("'for_sales'as model_type"),
            'created_at'
        );
        $supplier_payments = SupplierPayment::where('supplier_id',$id)
        ->select(
            'id',
            'supplier_id as user_id',
            'p_invoice_id as invoice_id',
            'value',
            'description',
            DB::raw("'for_purchasing'as model_type"),
            'created_at'
        );
        $discounts = DiscountOnStackHolder::where('user_id',$id)
        ->select(
            'id',
            'user_id',
            DB::raw('NULL as invoice_id'),
            'value',
            'description',
            DB::raw("'for_discounts'as model_type"),
            'created_at'
        );
        $payments = $customer_payments->unionAll($supplier_payments)
        ->unionAll($discounts)
        ->orderBy('created_at','desc')
        ->paginate(20);
        return view(config('app.theme').'.pages.supplier.payments', compact('payments','supplier'));
    }

    public function stake_holder_add_payments(Request $request,$id){
        $request->validate([
            'payment_value' => 'required|gt:0'
        ]);
        $stake_holder = StakeHolder::find($id);

        if($request->input('type_payment') == 1):
            CustomerPayment::create([
                'customer_id'  => $stake_holder->id,
                'value'        => $request->input('payment_value'),
                'description'  => $request->has('description') ? $request->input('description') : null
            ]);
        elseif($request->input('type_payment') == 2):
            SupplierPayment::create([
                'supplier_id'  => $stake_holder->id,
                'value'        => $request->input('payment_value'),
                'description'  => $request->has('description') ? $request->input('description') : null
            ]);
        elseif($request->input('type_payment') == 3):
            DiscountOnStackHolder::create([
                'user_id'      => $stake_holder->id,
                'value'        => $request->input('payment_value'),
                'description'  => $request->has('description') ? $request->input('description') : null
            ]);
        endif;

        return back();
    }

    public function delete_customer_payments($id){
        CustomerPayment::where('id',$id)->delete();
        return back();
    }

    public function delete_supplier_payments($id){
        SupplierPayment::where('id',$id)->delete();
        return back();
    }

    public function delete_user_discounts($id){
        DiscountOnStackHolder::where('id',$id)->delete();
        return back();
    }

    public function edit_customer_payment($payment_id){
        $payment = CustomerPayment::where('id',$payment_id)->first();
        return response()->json([
            'status' => true,
            'view'   => view(config('app.theme').'.pages.customer.model.payment', compact('payment'))->render()
        ]);
    }

    public function update_customer_payment(Request $request,$payment_id){
        CustomerPayment::where('id',$payment_id)->update([
            'value' => $request->input('value'),
            'description'  => $request->has('description') ? $request->input('description') : null
        ]);

        return back();
    }

    public function edit_user_discounts($payment_id){
        $payment = DiscountOnStackHolder::where('id',$payment_id)->first();
        return response()->json([
            'status' => true,
            'view'   => view(config('app.theme').'.pages.customer.model.payment', compact('payment'))->render()
        ]);
    }

    public function update_user_discounts(Request $request,$payment_id){
        $request->validate([
            'value' => 'required|gt:0'
        ]);
        DiscountOnStackHolder::where('id',$payment_id)->update([
            'value' => $request->input('value'),
            'description'  => $request->has('description') ? $request->input('description') : null
        ]);

        return back();
    }

    public function destroy_customer_payment(Request $request,$payment_id){
        CustomerPayment::where('id',$payment_id)->delete();
        return back();
    }

    public function edit_supplier_payment(Request $request,$payment_id){
        $payment = SupplierPayment::where('id',$payment_id)->first();
        return response()->json([
            'status' => true,
            'view'   => view(config('app.theme').'.pages.customer.model.payment', compact('payment'))->render()
        ]);
    }

    public function update_supplier_payment(Request $request,$payment_id){
        $request->validate([
            'value' => 'required|gt:0'
        ]);
        SupplierPayment::where('id',$payment_id)->update([
            'value'        => $request->input('value'),
            'description'  => $request->has('description') ? $request->input('description') : null
        ]);

        return back();
    }

    public function destroy_supplier_payment(Request $request,$payment_id){
        SupplierPayment::where('id',$payment_id)->delete();
        return back();
    }
}
