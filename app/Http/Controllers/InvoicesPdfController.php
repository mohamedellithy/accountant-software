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
        $order = Order::with('orderitems','orderitems.product','customer')->withSum('order_payments','value')->where('id',$id)->first();
        $view = \View::make(config('app.theme').'.pages.order.bills.pdf-bill',compact('order'));
        $html  = $view->render();
        $pdf   = new TCPDF();
        $pdf::SetTitle('فاتورة-بيع-رقم-'.$id);
        $pdf::AddPage();
        $pdf::setRTL(true);
        $pdf::SetFont('dejavusans', '', 10);
        $pdf::writeHTMLCell(0,0,'','',$html,'LRTB', 1, 0, true, 'R', false);
        $pdf::setPrintFooter(false);
        $pdf::setPrintHeader(false);
        $pdf::SetMargins(0,0,0);
        $pdf::setHeaderData('',0,'','',array(0,0,0), array(255,255,255) ); 
        $pdf::Output('فاتورة-بيع-رقم-'.$id.'.pdf','D');
    }

    public function download_pdf_purchasing_invoices_bill($id){
        $order     = PurchasingInvoice::with('invoice_items','invoice_items.product','supplier')->where('id',$id)->first();
        $view = \View::make(config('app.theme').'.pages.purchasing-invoice.bills.invoice-bill',compact('order'));
        $html  = $view->render();
        $pdf   = new TCPDF();
        $pdf::SetTitle('فاتورة-مشتريات-رقم-'.$id);
        $pdf::AddPage();
        $pdf::setRTL(true);
        $pdf::SetFont('dejavusans', '', 10);
        $pdf::writeHTMLCell(0,0,'','',$html,'LRTB', 1, 0, true, 'R', false);
        $pdf::setPrintFooter(false);
        $pdf::setPrintHeader(false);
        $pdf::SetMargins(0,0,0);
        $pdf::setHeaderData('',0,'','',array(0,0,0), array(255,255,255) ); 
        $pdf::Output('فاتورة-مشتريات-رقم-'.$id.'.pdf','D');
    }

    public function download_pdf_balance_bill($id){
        $customer = StakeHolder::with('orders')->withCount('orders')->withSum('orders','total_price')->find($id);

        $orders_items = DB::table('orders')->where('orders.customer_id',$id)
        ->join('order_items','orders.id','=','order_items.order_id')
        ->join('products','order_items.product_id','=','products.id')
        ->select('orders.id as order_id','orders.total_price','order_items.qty','order_items.price','orders.created_at','products.name as product_name')
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

        $orders = $orders_items->merge($orders_payemnts);

        $orders = $orders->merge($invoices_payments);

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
}
