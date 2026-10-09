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
        return round($price ?: 0,2).' '.' جنيه ';
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

    // Add returneds (sales returns vs purchasing returns)
    $sales_returns              = \DB::table('returneds')->where('customer_id', $customer->id)->where('type_return', 'sale')->sum('total_price');
    $purchasing_returns         = \DB::table('returneds')->where('customer_id', $customer->id)->where('type_return', 'purchasing')->sum('total_price');

    // Add returns_payments
    $sales_return_payments      = \DB::table('returns_payments')->where('stake_holder_id', $customer->id)->where('type_return', 'sale')->sum('value');
    $purchasing_return_payments = \DB::table('returns_payments')->where('stake_holder_id', $customer->id)->where('type_return', 'purchasing')->sum('value');

    // Add stakeholder discounts
    $discounts                  = \DB::table('discount_on_stack_holders')->where('user_id', $customer->id)->sum('value');

    $balance = $start_balance - $total_orders + $total_purchasing_invoices + $orders_payments - $total_purchasing_payments
        + $sales_returns - $purchasing_returns - $sales_return_payments + $purchasing_return_payments;

    if ($balance <= 0) {
        $balance += $discounts;
    } else {
        $balance -= $discounts;
    }

    return $balance;
}

function get_stakeholders_balances_summary(){
    $rows = \DB::table('stake_holders as sh')
        ->whereNull('sh.deleted_at')
        ->leftJoin(\DB::raw('(SELECT customer_id, SUM(total_price) as total FROM orders GROUP BY customer_id) as o'), 'o.customer_id', '=', 'sh.id')
        ->leftJoin(\DB::raw('(SELECT supplier_id, SUM(total_price) as total FROM purchasing_invoices GROUP BY supplier_id) as p'), 'p.supplier_id', '=', 'sh.id')
        ->leftJoin(\DB::raw('(SELECT customer_id, SUM(value) as total FROM customer_payments GROUP BY customer_id) as cp'), 'cp.customer_id', '=', 'sh.id')
        ->leftJoin(\DB::raw('(SELECT supplier_id, SUM(value) as total FROM supplier_payments GROUP BY supplier_id) as sp'), 'sp.supplier_id', '=', 'sh.id')
        ->leftJoin(\DB::raw("(SELECT customer_id, SUM(total_price) as total FROM returneds WHERE type_return = 'sale' GROUP BY customer_id) as sr"), 'sr.customer_id', '=', 'sh.id')
        ->leftJoin(\DB::raw("(SELECT customer_id, SUM(total_price) as total FROM returneds WHERE type_return = 'purchasing' GROUP BY customer_id) as pr"), 'pr.customer_id', '=', 'sh.id')
        ->leftJoin(\DB::raw("(SELECT stake_holder_id, SUM(value) as total FROM returns_payments WHERE type_return = 'sale' GROUP BY stake_holder_id) as srp"), 'srp.stake_holder_id', '=', 'sh.id')
        ->leftJoin(\DB::raw("(SELECT stake_holder_id, SUM(value) as total FROM returns_payments WHERE type_return = 'purchasing' GROUP BY stake_holder_id) as prp"), 'prp.stake_holder_id', '=', 'sh.id')
        ->leftJoin(\DB::raw('(SELECT user_id, SUM(value) as total FROM discount_on_stack_holders GROUP BY user_id) as d'), 'd.user_id', '=', 'sh.id')
        ->select([
            'sh.id',
            'sh.role',
            \DB::raw('COALESCE(sh.balance, 0) as start_balance'),
            \DB::raw('COALESCE(o.total, 0) as total_orders'),
            \DB::raw('COALESCE(p.total, 0) as total_purchasing_invoices'),
            \DB::raw('COALESCE(cp.total, 0) as orders_payments'),
            \DB::raw('COALESCE(sp.total, 0) as total_purchasing_payments'),
            \DB::raw('COALESCE(sr.total, 0) as sales_returns'),
            \DB::raw('COALESCE(pr.total, 0) as purchasing_returns'),
            \DB::raw('COALESCE(srp.total, 0) as sales_return_payments'),
            \DB::raw('COALESCE(prp.total, 0) as purchasing_return_payments'),
            \DB::raw('COALESCE(d.total, 0) as discounts'),
        ])
        ->get();

    $total_must_collect = 0;
    $total_must_paid = 0;

    foreach ($rows as $row) {
        $balance = $row->start_balance - $row->total_orders + $row->total_purchasing_invoices 
            + $row->orders_payments - $row->total_purchasing_payments
            + $row->sales_returns - $row->purchasing_returns 
            - $row->sales_return_payments + $row->purchasing_return_payments;

        if ($balance <= 0) {
            $balance += $row->discounts;
        } else {
            $balance -= $row->discounts;
        }

        if ($balance < 0) {
            $total_must_collect += abs($balance);
        } elseif ($balance > 0) {
            $total_must_paid += $balance;
        }
    }

    return [
        'total_must_collect' => $total_must_collect,
        'total_must_paid'    => $total_must_paid,
    ];
}


function IndexList($collection,$loop){
    return ($collection->total()- $loop->index ) - (($collection->currentpage()-1) * $collection->perpage() );
}


function CustomPaginateData($allData,$perPage = 10){
    // Pagination يدوي
    $page = request()->get('page', 1);
    $offset = ($page - 1) * $perPage;

    $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
        $allData->slice($offset, $perPage), // البيانات للصفحة الحالية
        $allData->count(),                  // العدد الكلي
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    return $paginatedData;
}

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        try {
            $value = \App\Models\Setting::get($key);
            return $value !== null ? $value : $default;
        } catch (\Exception $e) {
            return $default;
        }
    }
}

if (!function_exists('color_is_dark')) {
    function color_is_dark($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } elseif (strlen($hex) == 6) {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        } else {
            return false;
        }
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        return ($yiq < 140);
    }
}

?>
