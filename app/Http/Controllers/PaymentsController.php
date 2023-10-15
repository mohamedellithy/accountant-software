<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\StakeHolder;
use Illuminate\Http\Request;
use App\Models\Total_Payments;

class PaymentsController extends Controller
{
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
}
