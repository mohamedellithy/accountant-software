<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\StakeHolder;
use App\Models\PurchasingInvoice;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\DB;
class InvoicesPdfController extends Controller
{
    public function download_pdf_payments_bill($id){
        $order     = Order::with('orderitems','orderitems.product','customer')->withSum('order_payments','value')->where('id',$id)->first();
        $view      = \View::make(config('app.theme').'.pages.order.bills.pdf-payments',compact('order'));
        $html = $view->render();
        $pdf = new TCPDF();
        $pdf::SetTitle('مدفوعات-العميل-لطلبية-رقيم'.$id);
        $pdf::AddPage();
        $pdf::setRTL(true);
        $pdf::SetFont('dejavusans', '', 10);
        $pdf::writeHTMLCell(0,0,'','',$html,'LRTB', 1, 0, true, 'R', false);
        $pdf::setPrintFooter(false);
        $pdf::setPrintHeader(false);
        $pdf::SetMargins(0,0,0);
        $pdf::setHeaderData('',0,'','',array(0,0,0), array(255,255,255) ); 
        $pdf::Output('مدفوعات-العميل-لطلبية-رقيم'.$id.'.pdf','D');
    }

    public function download_pdf_order_bill($id){
        $order  = Order::with('orderitems','orderitems.product','customer')->withSum('order_payments','value')->where('id',$id)->first();
        $view   = \View::make(config('app.theme').'.pages.order.bills.pdf-bill',compact('order'));
        $html   = $view->render();
        $pdf    = new TCPDF();
        $pdf::SetTitle('فاتورة-بيع-رقم-'.$id);
        $pdf::AddPage();
        $pdf::setRTL(true);
        $pdf::SetFont('dejavusans', '', 10);
        $pdf::writeHTMLCell(0,0,'','',$html,'LRTB', 1, 0, true, 'R', false);
        $pdf::setPrintFooter(false);
        $pdf::setPrintHeader(false);
        $pdf::SetMargins(0,0,0);
        $pdf::setHeaderData('',0,'','',array(0,0,0), array(255,255,255) ); 
        $pdf::Output('فاتورة-بيع-رقم-'.$order->customer->name.'-'.$id.'.pdf','D');
    }

    public function download_pdf_purchasing_invoices_bill($id){
        $order     = PurchasingInvoice::with('invoice_items','invoice_items.product','supplier')->where('id',$id)->first();
        $view      = \View::make(config('app.theme').'.pages.purchasing-invoice.bills.invoice-bill',compact('order'));
        $html      = $view->render();
        $pdf       = new TCPDF();
        $pdf::SetTitle('فاتورة-مشتريات-رقم-'.$id);
        $pdf::AddPage();
        $pdf::setRTL(true);
        $pdf::SetFont('dejavusans', '', 10);
        $pdf::writeHTMLCell(0,0,'','',$html,'LRTB', 1, 0, true, 'R', false);
        $pdf::setPrintFooter(false);
        $pdf::setPrintHeader(false);
        $pdf::SetMargins(0,0,0);
        $pdf::setHeaderData('',0,'','',array(0,0,0), array(255,255,255) ); 
        $pdf::Output('فاتورة-مشتريات-رقم-'.$order->supplier->name.'-'.$id.'.pdf','D');
    }

    public function download_pdf_balance_bill($id){
        $customer = StakeHolder::with('orders')->withCount('orders')->withSum('orders','total_price')->find($id);

        $orders_items = DB::table('orders')->where('orders.customer_id',$id)
        ->join('order_items','orders.id','=','order_items.order_id')
        ->join('products','order_items.product_id','=','products.id')
        ->select('orders.id as order_id','orders.total_price','orders.discount','order_items.qty','order_items.price','orders.created_at','products.name as product_name')
        ->groupBy('orders.id','order_items.id')
        ->get();

        $purchasing_items = DB::table('purchasing_invoices')->where('purchasing_invoices.supplier_id',$id)
        ->join('invoice_items','purchasing_invoices.id','=','invoice_items.invoice_id')
        ->join('products','invoice_items.product_id','=','products.id')
        ->select('purchasing_invoices.id as purchasing_invoices_id','purchasing_invoices.total_price','invoice_items.qty','invoice_items.price','purchasing_invoices.created_at','products.name as product_name')
        ->groupBy('purchasing_invoices.id','invoice_items.id')
        ->get();



        $orders_payemnts = DB::table('customer_payments')->where([
            'customer_payments.customer_id' => $id
        ])->select('customer_payments.id as customer_payments_id','customer_payments.value as payment_values','customer_payments.created_at','customer_payments.s_invoice_id as id')
          ->get();

        $invoices_payments = DB::table('supplier_payments')->where([
            'supplier_payments.supplier_id' => $id
        ])->select('supplier_payments.id as supplier_payments_id','supplier_payments.value as payment_values','supplier_payments.created_at','supplier_payments.p_invoice_id as id')
          ->get();

        
        $returned_items = DB::table('returneds')->where('returneds.customer_id',$id)
          ->join('return_items','returneds.id','=','return_items.return_id')
          ->join('products','return_items.product_id','=','products.id')
          ->select('returneds.id as returned_id','returneds.total_price','returneds.type_return','return_items.quantity','return_items.price','returneds.created_at','products.name as product_name')
          ->groupBy('returneds.id','return_items.id')
          ->get();
        
        $returned_payments = DB::table('returns_payments')->where([
            'returns_payments.stake_holder_id' => $id
        ])->select('returns_payments.id as returns_payments_id','returns_payments.value as payment_values','returns_payments.type_return','returns_payments.created_at','returns_payments.r_invoice_id as id')
          ->get();

        $disounts = DB::table('discount_on_stack_holders')->where([
            'discount_on_stack_holders.user_id' => $id
        ])->select(
            'discount_on_stack_holders.id as discount_id',
            'discount_on_stack_holders.value as payment_values',
            'discount_on_stack_holders.created_at',
            'discount_on_stack_holders.description')
        ->get();

        $orders = $orders_items->merge($orders_payemnts);

        $orders = $orders->merge($invoices_payments);

        $orders = $orders->merge($returned_items);

        $orders = $orders->merge($returned_payments);
        $orders = $orders->merge($disounts);

        $orders = $orders->merge($purchasing_items)->sortBy('created_at');   

        $view = \View::make(config('app.theme').'.pages.customer.bills.balance-bill',compact('orders','customer'));
        $html  = $view->render();
        $pdf   = new TCPDF();
        $pdf::SetTitle('كشف-حساب-عميل-');
        $pdf::AddPage();
        $pdf::setRTL(true);
        $pdf::SetFont('dejavusans', '', 10);
        $pdf::writeHTMLCell(0,0,'','',$html,'LRTB', 1, 0, true, 'R', false);
        $pdf::setPrintFooter(false);
        $pdf::setPrintHeader(false);
        $pdf::SetMargins(0,0,0);
        $pdf::SetAutoPageBreak(TRUE,100);
        $pdf::setHeaderData('',0,'','',array(0,0,0), array(255,255,255) ); 
        $pdf::Output('كشف-حساب-عميل-'.$customer->name.'.pdf','D');
    }

    public function download_pdf_customers_debts(Request $request)
    {
        $query = StakeHolder::where('role', 'customer');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $allCustomers = $query->get();

        $customers = $allCustomers->filter(function($customer) {
            $balance = get_balance_stake_holder($customer);
            $customer->current_balance = $balance;
            return $balance < 0;
        });

        $total_debts = $customers->sum(function($customer) {
            return abs($customer->current_balance);
        });

        foreach ($customers as $customer) {
            $last_order = $customer->orders()->latest('created_at')->first();
            $last_purchase = $customer->purchasing_invoices()->latest('created_at')->first();
            $last_cust_payment = $customer->customer_payments()->latest('created_at')->first();
            $last_supp_payment = $customer->supplier_payments()->latest('created_at')->first();

            $dates = [];
            if ($last_order) $dates[] = $last_order->created_at;
            if ($last_purchase) $dates[] = $last_purchase->created_at;
            if ($last_cust_payment) $dates[] = $last_cust_payment->created_at;
            if ($last_supp_payment) $dates[] = $last_supp_payment->created_at;

            $last_date = !empty($dates) ? max($dates) : null;
            $customer->last_transaction_date = $last_date ? \Carbon\Carbon::parse($last_date)->format('Y-m-d') : '-';
        }

        $view = \View::make(config('app.theme').'.pages.customer.bills.debts-pdf', compact('customers', 'total_debts'));
        $html = $view->render();
        
        $pdf = new TCPDF();
        $pdf::SetTitle('تقرير-المطلوب-تحصيله-من-العملاء');
        $pdf::AddPage();
        $pdf::setRTL(true);
        $pdf::SetFont('dejavusans', '', 10);
        $pdf::writeHTMLCell(0,0,'','',$html,'LRTB', 1, 0, true, 'R', false);
        $pdf::setPrintFooter(false);
        $pdf::setPrintHeader(false);
        $pdf::SetMargins(0,0,0);
        $pdf::setHeaderData('',0,'','',array(0,0,0), array(255,255,255) ); 
        $pdf::Output('تقرير-المطلوب-تحصيله-من-العملاء.pdf','D');
    }

    public function download_pdf_suppliers_debts(Request $request)
    {
        $query = StakeHolder::where('role', 'supplier');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $allSuppliers = $query->get();

        $suppliers = $allSuppliers->filter(function($supplier) {
            $balance = get_balance_stake_holder($supplier);
            $supplier->current_balance = $balance;
            return $balance > 0;
        });

        $total_debts = $suppliers->sum(function($supplier) {
            return $supplier->current_balance;
        });

        foreach ($suppliers as $supplier) {
            $last_order = $supplier->orders()->latest('created_at')->first();
            $last_purchase = $supplier->purchasing_invoices()->latest('created_at')->first();
            $last_cust_payment = $supplier->customer_payments()->latest('created_at')->first();
            $last_supp_payment = $supplier->supplier_payments()->latest('created_at')->first();

            $dates = [];
            if ($last_order) $dates[] = $last_order->created_at;
            if ($last_purchase) $dates[] = $last_purchase->created_at;
            if ($last_cust_payment) $dates[] = $last_cust_payment->created_at;
            if ($last_supp_payment) $dates[] = $last_supp_payment->created_at;

            $last_date = !empty($dates) ? max($dates) : null;
            $supplier->last_transaction_date = $last_date ? \Carbon\Carbon::parse($last_date)->format('Y-m-d') : '-';
        }

        $view = \View::make(config('app.theme').'.pages.supplier.bills.debts-pdf', compact('suppliers', 'total_debts'));
        $html = $view->render();
        
        $pdf = new TCPDF();
        $pdf::SetTitle('تقرير-المطلوب-تسديده-للموردين');
        $pdf::AddPage();
        $pdf::setRTL(true);
        $pdf::SetFont('dejavusans', '', 10);
        $pdf::writeHTMLCell(0,0,'','',$html,'LRTB', 1, 0, true, 'R', false);
        $pdf::setPrintFooter(false);
        $pdf::setPrintHeader(false);
        $pdf::SetMargins(0,0,0);
        $pdf::setHeaderData('',0,'','',array(0,0,0), array(255,255,255) ); 
        $pdf::Output('تقرير-المطلوب-تسديده-للموردين.pdf','D');
    }
}
