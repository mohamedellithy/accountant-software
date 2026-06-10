<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\StakeHolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $suppliers = StakeHolder::query();
        $per_page = 10;
        if ($request->has('rows')) {
            $per_page = $request->query('rows');
        }

        $data = $request->all();
        $suppliers->when(isset($data['filter']) && isset($data['filter']['supplier_id']), function ($q) use($data) {
            return $q->where('id',$data['filter']['supplier_id']);
        },function($q){
            $q->where(function($qb){
                $qb->where('role','supplier')
                ->orWhereHas('products');
            });
        });
        
        $suppliers = $suppliers->withCount('orders','purchasing_invoices')
        ->withSum('orders','total_price')
        ->withSum('purchasing_invoices','total_price');
        $suppliers = $suppliers->paginate($per_page);
        $suppliers_all = StakeHolder::select('id','name')->get();
        return view(config('app.theme').'.pages.supplier.index', compact('suppliers','suppliers_all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        $request->merge([
            'role' => 'supplier'
        ]);

        $supplier = StakeHolder::create($request->only([
            'name',
            'phone',
            'role',
            'balance'
        ]));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إضافة المورد بنجاح',
                'supplier' => $supplier
            ]);
        }

        return redirect()->route('admin.suppliers.index')->with('success_message', 'تم اضافة مزود');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $supplier = StakeHolder::with('orders')->withCount('orders')->withSum('orders','total_price')->find($id);

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

        // حساب الرصيد التراكمي الجاري لكل حركة في المجموعة الكاملة
        $balance = $supplier->balance ?: 0;
        $applied_discounts = [];
        foreach ($orders as $order) {
            if (isset($order->order_id)) {
                $balance = $balance - ($order->qty * $order->price);
                if (isset($order->discount) && $order->discount > 0 && !in_array($order->order_id, $applied_discounts)) {
                    $balance = $balance + $order->discount;
                    $applied_discounts[] = $order->order_id;
                }
            } elseif (isset($order->purchasing_invoices_id)) {
                $balance = $balance + ($order->qty * $order->price);
            } elseif (isset($order->customer_payments_id)) {
                $balance = $balance + $order->payment_values;
            } elseif (isset($order->supplier_payments_id)) {
                $balance = $balance - $order->payment_values;
            } elseif (isset($order->returned_id)) {
                if ($order->type_return == 'sale') {
                    $balance = $balance + ($order->quantity * $order->price);
                }
                if ($order->type_return == 'purchasing') {
                    $balance = $balance - ($order->quantity * $order->price);
                }
            } elseif (isset($order->returns_payments_id)) {
                if ($order->type_return == 'sale') {
                    $balance = $balance - $order->payment_values;
                }
                if ($order->type_return == 'purchasing') {
                    $balance = $balance + $order->payment_values;
                }
            } elseif (isset($order->discount_id)) {
                if ($balance <= 0) {
                    $balance = $balance + $order->payment_values;
                } else {
                    $balance = $balance - $order->payment_values;
                }
            }
            $order->running_balance = $balance;
        }

        $print_all = $request->has('print_all');

        if ($print_all) {
            $page_initial_balance = $supplier->balance ?: 0;
        } else {
            $perPage = 20;
            $page = $request->get('page', 1);

            if ($page == 1) {
                $page_initial_balance = $supplier->balance ?: 0;
            } else {
                $prev_index = ($page - 1) * $perPage - 1;
                $prev_order = $orders->values()->get($prev_index);
                $page_initial_balance = $prev_order ? $prev_order->running_balance : ($supplier->balance ?: 0);
            }

            $orders = CustomPaginateData($orders, $perPage);
        }

        return view(config('app.theme').'.pages.supplier.show', compact('supplier', 'orders', 'page_initial_balance', 'print_all'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier   = StakeHolder::find($id);
        return response()->json([
            'status' => true,
            'view'   => view(config('app.theme').'.pages.supplier.model.edit', compact('supplier'))->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, $id)
    {
        $supplier = StakeHolder::where('id', $id)->update($request->only([
            'name',
            'phone',
            'balance'
        ]));
        return redirect()->route('admin.suppliers.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = StakeHolder::destroy($id);

        return redirect()->route('admin.suppliers.index');

    }
    public function supplierProduct($id)
    {
        $supplierproducts = supplier::where('id', $id)->with('products')->first();
        return view('pages.admin.supplier.supplierproduct', compact('supplierproducts'));

    }

    public function debtsReport(Request $request)
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

        $perPage = 20;
        $totalCount = $suppliers->count();
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $perPage;

        $paginatedItems = $suppliers->slice($offset, $perPage);
        foreach ($paginatedItems as $supplier) {
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

        $paginatedSuppliers = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedItems,
            $totalCount,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view(config('app.theme').'.pages.supplier.debts', [
            'suppliers' => $paginatedSuppliers,
            'total_debts' => $total_debts,
            'search' => $request->search
        ]);
    }
}
