<?php
if (!function_exists('IsActiveOnlyIf')) {
    function IsActiveOnlyIf($routes = [])
    {
        if (count($routes) == 0) {
            return '';
        }

        $current_route = \Route::currentRouteName();

        if (in_array($current_route, $routes)):
            return 'active open';
        endif;

        return '';
    }
}



if(!function_exists('TrimLongText')){
    function TrimLongText($text,$length = 100){
        $text = trim(strip_tags($text));
        $text  = str_replace('&nbsp;', ' ', $text);
        return mb_substr($text,0,$length).' ... ';
    }
}

if(!function_exists('formate_price')) {
    function formate_price($price)
    {
        return round($price,2).' '.' جنيه ';
    }
}

function generateOrderNumber(){
    $payment_no = (intval(\App\Models\Order::max('id')) ?? 0) + 1;
    // fill 000
    $nextPaymentNumber = str_pad($payment_no, 7, '0', STR_PAD_LEFT);
    // Compose the full serial
    return $nextPaymentNumber;
}

function generatePurchasingOrderNumber(){
    $payment_no = (intval(\App\Models\PurchasingInvoice::max('id')) ?? 0) + 1;
    // fill 000
    $nextPaymentNumber = str_pad($payment_no, 7, '0', STR_PAD_LEFT);
    // Compose the full serial
    return $nextPaymentNumber;
}

function generateReturnOrderNumber(){
    $payment_no = (intval(\App\Models\Returned::max('id')) ?? 0) + 1;
    // fill 000
    $nextPaymentNumber = str_pad($payment_no, 7, '0', STR_PAD_LEFT);
    // Compose the full serial
    return $nextPaymentNumber;
}


function get_balance_stake_holder($customer){
    $start_balance     = $customer->balance ?: 0;
    $total_orders      = $customer->orders()->sum('total_price');
    $total_purchasing_invoices    = $customer->purchasing_invoices()->sum('total_price');
    $orders_payments              = $customer->customer_payments()->sum('value');
    $total_purchasing_payments    = $customer->supplier_payments()->sum('value');

    return $start_balance - $total_orders + $total_purchasing_invoices + $orders_payments - $total_purchasing_payments;
}

function IndexList($collection,$loop){
    return ($collection->total()- $loop->index ) - (($collection->currentpage()-1) * $collection->perpage() );
}

?>
