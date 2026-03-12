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
        $statics['count_products']   = \App\Models\Product::count();
        $statics['count_stocks']     = \App\Models\Stock::count();
        $statics['sales_total']      = \App\Models\Order::sum('total_price');
        $statics['purchasing_total'] = \App\Models\PurchasingInvoice::sum('total_price');
        $statics['return_total']     = \App\Models\ReturnItem::sum(\DB::raw('return_items.quantity * return_items.price'));
        $statics['expenses_total']   = \App\Models\Expense::sum('price');
        $statics['customer_payments_total']   = \App\Models\CustomerPayment::sum('value');
        $statics['supplier_payments_total']   = \App\Models\SupplierPayment::sum('value');
        $statics['customer_counts']           = \App\Models\StakeHolder::customer()->count();
        $statics['supplier_counts']           = \App\Models\StakeHolder::supplier()->count();
        // total_must_collect
        $total_must_collect        = \App\Models\Order::select(DB::raw('COALESCE(SUM(total_price),0) as sales_total'))
        ->selectSub(function($query){
            $query->from('returneds')->where('type_return','sale')
            ->select(DB::raw('COALESCE(SUM(total_price),0)'));
        },'return_sales_total')
        ->selectSub(function($query){
            $query->from('discount_on_stack_holders')->select(DB::raw('COALESCE(SUM(value),0)'));
        },'discounts_total')
        ->selectSub(function($query){
            $query->from('customer_payments')->select(DB::raw('COALESCE(SUM(value),0)'));
        },'customer_payments_total')
         ->selectSub(function($query){
            $query->from('stake_holders')->where('balance','<',0)->select(DB::raw('COALESCE(SUM(abs(balance)),0)'));
        },'customer_total_balance')
        ->first();
        $statics['total_must_collect'] = $total_must_collect->sales_total + 
        $total_must_collect->customer_total_balance - 
        $total_must_collect->return_sales_total - 
        $total_must_collect->discounts_total - 
        $total_must_collect->customer_payments_total;


        // total_must_paid
        $total_must_paid        = \App\Models\PurchasingInvoice::select(DB::raw('COALESCE(SUM(total_price),0) as purchasing_total'))
        ->selectSub(function($query){
            $query->from('returneds')->where('type_return','purchasing')
            ->select(DB::raw('COALESCE(SUM(total_price),0)'));
        },'return_purchasing_total')
        ->selectSub(function($query){
            $query->from('discount_on_stack_holders')->select(DB::raw('COALESCE(SUM(value),0)'));
        },'discounts_total')
        ->selectSub(function($query){
            $query->from('supplier_payments')->select(DB::raw('COALESCE(SUM(value),0)'));
        },'supplier_payments_total')
         ->selectSub(function($query){
            $query->from('stake_holders')->where('balance','>',0)->select(DB::raw('COALESCE(SUM(abs(balance)),0)'));
        },'supplier_total_balance')
        ->first();
        $statics['total_must_paid'] = $total_must_paid->purchasing_total + 
        $total_must_paid->supplier_total_balance - 
        $total_must_paid->return_purchasing_total - 
        $total_must_paid->discounts_total - 
        $total_must_paid->supplier_payments_total;
        return view('Theme_2.pages.dashboard')->with($statics);
    }
}
