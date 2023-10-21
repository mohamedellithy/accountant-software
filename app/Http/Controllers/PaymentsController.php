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

    public function debit_payments(){
        // مدين

    }

    public function credit_payments(Request $request){
        // دائن

        $payments = CustomerPayment::query();
        $payments = $payments->with('customer');
        $per_page = 10;


        $payments->when(request('search') != null, function ($q) {
            return $q->where('customer', function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            });
        });

        $payments->when(request('filter') == 'sort_asc', function ($q) {
            return $q->orderBy('created_at', 'asc');
        },function ($q) {
            return $q->orderBy('created_at', 'desc');
        });

        if ($request->has('rows')):
            $per_page = $request->query('rows');
        endif;

        $payments = $payments->paginate($per_page);
        $customers = StakeHolder::select('id','name')->orderBy('name', 'asc')->get();
        return view(config('app.theme').'.pages.payment.credit-index', compact('payments','customers'));


    }
    public function index(Request $request)
    {
        $payments = Total_Payments::query();
        $payments = $payments->with('customer');
        $per_page = 10;


        $payments->when(request('search') != null, function ($q) {
            return $q->where('customer', function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            });
        });

        $payments->when(request('filter') == 'sort_asc', function ($q) {
            return $q->orderBy('created_at', 'asc');
        },function ($q) {
            return $q->orderBy('created_at', 'desc');
        });

        if ($request->has('rows')):
            $per_page = $request->query('rows');
        endif;

        $payments = $payments->paginate($per_page);
        $customers = StakeHolder::select('id','name')->orderBy('name', 'asc')->get();
        return view(config('app.theme').'.pages.payment.index', compact('payments','customers'));

    }

    public function customer_payments(Request $request,$id){

        $payments = Payment::query();
        $payments =  $payments->where('stake_holder_id', $id)->get();

        $per_page = 10;


        if ($request->has('rows')):
            $per_page = $request->query('rows');
        endif;

       // $payments = $payments->paginate($per_page);
        return view(config('app.theme').'.pages.payment.customer', compact('payments'));
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
