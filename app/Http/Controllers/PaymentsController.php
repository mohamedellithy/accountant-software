<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\StakeHolder;
use Illuminate\Http\Request;
use App\Models\CustomerPayment;
use App\Models\SupplierPayment;

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
        $customer_payments = CustomerPayment::where('customer_id',$id)->get();
        $supplier_payments = SupplierPayment::where('supplier_id',$id)->get();
        $payments = $customer_payments->merge($supplier_payments)->sortByDesc('created_at');
        //dd($payments);
        return view(config('app.theme').'.pages.customer.payments', compact('payments','customer'));
    }

    public function supplier_payments_lists($id){
        $supplier = StakeHolder::find($id);
        $customer_payments = CustomerPayment::where('customer_id',$id)->get();
        $supplier_payments = SupplierPayment::where('supplier_id',$id)->get();
        $payments = $customer_payments->merge($supplier_payments)->sortByDesc('created_at');
        return view(config('app.theme').'.pages.supplier.payments', compact('payments','supplier'));
    }

    public function stake_holder_add_payments(Request $request,$id){
        $stake_holder = StakeHolder::find($id);
        if($request->input('type_payment') == 1):
            CustomerPayment::create([
                'customer_id'  => $stake_holder->id,
                'value'        => $request->input('payment_value')
            ]);
        elseif($request->input('type_payment') == 2):
            SupplierPayment::create([
                'supplier_id'  => $stake_holder->id,
                'value'        => $request->input('payment_value')
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
}
