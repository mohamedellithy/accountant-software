<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // stocks
        $statics['count_products']         = \App\Models\Product::count();
        $statics['count_stocks']           = \App\Models\Stock::count();
        $statics['count_low_of_stock']     = \App\Models\Stock::where('quantity','<=',0)->count();
        $statics['cost_total_stocks']      = \App\Models\Stock::sum(DB::raw('quantity * purchasing_price'));

        // invoices
        $statics['sales_total']      = \App\Models\Order::sum('total_price');
        $statics['purchasing_total'] = \App\Models\PurchasingInvoice::sum('total_price');
        $statics['return_total']     = \App\Models\ReturnItem::sum(\DB::raw('return_items.quantity * return_items.price'));
        $statics['expenses_total']   = \App\Models\Expense::sum('price');
        
        // payments
        $statics['customer_payments_total']   = \App\Models\CustomerPayment::sum('value');
        $statics['supplier_payments_total']   = \App\Models\SupplierPayment::sum('value');

        // stackHolders
        $statics['customer_counts']           = \App\Models\StakeHolder::customer()->count();
        $statics['supplier_counts']           = \App\Models\StakeHolder::supplier()->count();

        // stackHolders balances summary (handles dual role customer/supplier, initial balances, returns & payments)
        $balances_summary = get_stakeholders_balances_summary();
        $statics['total_must_collect'] = $balances_summary['total_must_collect'];
        $statics['total_must_paid']    = $balances_summary['total_must_paid'];

        // return 
        return view('Theme_2.pages.dashboard')->with($statics);
    }
}
