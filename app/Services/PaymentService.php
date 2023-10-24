<?php

namespace App\Services;
use App\Models\User;
use App\Models\Order;
use App\Models\Supplier;
use App\Mail\VerifyCodeMail;
use App\Models\CustomerPayment;
use App\Models\SupplierPayment;
use App\Models\PurchasingInvoice;
use Illuminate\Support\Facades\Mail;

class PaymentService
{
    public static function create_customer_payments_by_order(Order $order,$payment_value = null){
        
        if($payment_value === '0') return;

        if($order->payment_type === 'cashe'):
            $payment_value = $order->total_price;
        endif;

        // check if payments is greater than
        $all_payments = $order->order_payments()->sum('value') + $payment_value;
        if(($order->order_payments()->exists())  && ($all_payments > $order->total_price)) return;

        CustomerPayment::create([
            'customer_id'  => $order->customer_id,
            's_invoice_id' => $order->id,
            'value'        => $payment_value
        ]);
    }

    public static function update_customer_payments_by_order(Order $order,$payment_value = null){
        CustomerPayment::where([
            'customer_id'  => $order->customer_id,
            's_invoice_id' => $order->id
        ])->update([
            'value'        => $payment_value
        ]);
    }

    public static function create_supplier_payments_by_invoice(PurchasingInvoice $invoice,$payment_value = null){
        if($payment_value === '0') return;
        
        if($invoice->payment_type === 'cashe'):
            $payment_value = $invoice->total_price;
        endif;

        // check if payments is greater than
        $all_payments = $invoice->invoice_payments()->sum('value') + $payment_value;
        if(($invoice->invoice_payments()->exists())  && ($all_payments > $invoice->total_price)) return;

        SupplierPayment::create([
            'supplier_id'  => $invoice->supplier_id,
            'p_invoice_id' => $invoice->id,
            'value'        => $payment_value
        ]);
    }

    public static function update_supplier_payments_by_invoice(PurchasingInvoice $invoice,$payment_value = null){
        SupplierPayment::where([
            'supplier_id'  => $invoice->supplier_id,
            'p_invoice_id' => $invoice->id,
        ])->update([
            'value'        => $payment_value
        ]);
    }
}
