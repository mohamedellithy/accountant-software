<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\StakeHolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = StakeHolder::query();

        $customers = $customers->where('role','customer');

        $customers = $customers->orWhereHas('orders');

        $customers = $customers->withCount('orders','purchasing_invoices');

        $customers = $customers->withSum('orders','total_price')
        ->withSum('purchasing_invoices','total_price');

        $per_page = 10;
        if ($request->has('search')) {
            $customers = $customers->where('name', 'like', '%' . $request->query('search') . '%');
        }
        if ($request->has('rows')) {
            $per_page = $request->query('rows');
        }

        $customers = $customers->paginate($per_page);

        return view(config('app.theme').'.pages.customer.index', compact('customers'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $request->merge([
            'role' => 'customer'
        ]);

        StakeHolder::create($request->only([
            'name',
            'phone',
            'role',
            'balance'
        ]));
        return redirect()->back()->with('success_message', 'تم اضافة عميل');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
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

        //dd($orders);

        return view(config('app.theme').'.pages.customer.show', compact('customer','orders'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $customer   = StakeHolder::find($id);
        return response()->json([
            'status' => true,
            'view'   => view(config('app.theme').'.pages.customer.model.edit', compact('customer'))->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $customer = StakeHolder::where('id', $id)->update($request->only([
            'name',
            'phone',
            'balance'
        ]));
        return redirect()->back()->with('success_message', 'تم تعديل عميل');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = StakeHolder::destroy($id);

        return redirect()->back()->with('success_message', 'تم حذف العميل');

    }
    public function customerOrder($id)
    {
        $customers = Order::where('customer_id', $id)->where('order_status','completed')->with('customer')->first();
        $customerOrders = Order::where('customer_id', $id)->where('order_status','completed')->with('orderitems', 'orderitems.product')->get();
        return view('pages.admin.customer.customerorder', compact('customers','customerOrders'));

    }
}
