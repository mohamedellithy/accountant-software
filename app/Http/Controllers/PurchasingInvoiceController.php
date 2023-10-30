<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Payment;
use App\Models\Product;
use App\Models\StakeHolder;
use App\Models\InvoiceItems;
use Illuminate\Http\Request;
use App\Models\Total_Payments;
use App\Services\PaymentService;
use App\Models\PurchasingInvoice;
use Illuminate\Support\Facades\DB;

class PurchasingInvoiceController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = PurchasingInvoice::query();
        $orders = $orders->with('supplier', 'invoice_items', 'invoice_items.product')->withSum('invoice_payments','value');;
        $per_page = 10;

        $orders->when(request('search') != null, function ($q) {
            return $q->where('order_number', 'like', '%' . request('search') . '%')->orWhereHas('supplier', function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            });
        });

        if ($request->has('from') and $request->has('to') and $request->get('from') != "" and $request->get('to') != "") {

            $from=$request->get('from');
            $to=$request->get('to');
            $orders->whereBetween('created_at',[$from,$to]);
        }


        $orders->when(request('filter') == 'high-price', function ($q) {
            return $q->orderBy('total_price', 'desc');
        },function ($q) {
            return $q->orderBy('total_price', 'asc');
        });

        if ($request->has('customer_filter') and $request->get('customer_filter') != "") {

            $orders->where('supplier_id',$request->get('customer_filter'));
        }


        if ($request->has('rows')):
            $per_page = $request->query('rows');
        endif;

        $orders = $orders->paginate($per_page);
        $customers = StakeHolder::select('id','name')->orderBy('name', 'asc')->get();

        return view(config('app.theme').'.pages.purchasing-invoice.index', compact('orders','customers'));

    }
    public function ajax_get_supplier_info($id)
    {
        $data = StakeHolder::where('id', $id)->first();
        return response()->json($data);
    }
    public function ajax_get_product_info($id)
    {
        $product = Product::with('stock','stock.supplier')->where('id',$id)->first();
        return response()->json(['product' => $product]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = StakeHolder::select('id','name')->get();
        $products  = Product::all();
        return view(config('app.theme').'.pages.purchasing-invoice.create', compact('suppliers', 'products'));
    }

    /**
     * Show the form for editing a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order     = PurchasingInvoice::with('invoice_items')->where('id',$id)->first();
        $suppliers = StakeHolder::select('id','name')->get();
        $products  = Product::all();
        return view(config('app.theme').'.pages.purchasing-invoice.edit', compact('order','suppliers','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([

            'addmore.*.product_id' => 'required',
            'addmore.*.qty'        => ['required', 'numeric'],
            'addmore.*.price'      => ['required', 'numeric']
        ]);

        $order = PurchasingInvoice::Create([
            'order_number' => $request->input('order_number'),
            'supplier_id'  => $request->input('supplier_id'),
            'total_price'  => 0,
            'quantity'     => count($request->input('addmore')),
            'payment_type' => $request->input('payment_type')
        ]);

        array_filter($request->input('addmore'));

        foreach($request->input('addmore') as $value):
            $product = Product::with('stock')->where('id', $value['product_id'])->first();
            if(!isset($value['price'])):
                $value['price'] =  $product->stock->price;
            endif;

            if(!isset($value['qty'])):
                $value['qty'] =  1;
            endif;

            $order->invoice_items()->create($value);


            if($request->input('update_stock')):
                $stock = Stock::where('product_id',$product->id)->first();
                if(!$stock):
                    $stock = new Stock();
                    $stock->product_id       = $product->id;
                    $stock->quantity         = $value['qty'];
                    $stock->purchasing_price = $value['price'];
                    $stock->sale_price       = $value['price'] + 20;
                    $stock->supplier_id      = $request->input('supplier_id');
                else:
                    $stock->quantity += $value['qty'];
                endif;
                $stock->save();
            endif;

        endforeach;

        if($order->invoice_items()->count() == count($request->input('addmore'))):
            $order->update([
                'total_price' => $order->invoice_items()->sum(DB::raw("(invoice_items.qty * invoice_items.price)")) ,
                'quantity' => $order->invoice_items()->count()
            ]);

            PaymentService::create_supplier_payments_by_invoice($order,$request->input('payment_value'));
        else:
            $order->delete();
        endif;
        return redirect()->route('admin.purchasing-invoices.index')->with('success_message', 'تم اضافة طلب');

    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $request->validate([
            'addmore.*.product_id' => 'required',
            'addmore.*.qty'        => ['required', 'numeric'],
            'addmore.*.price'      => ['required', 'numeric']
        ]);

        $order = PurchasingInvoice::where([
            'id' => $id
        ])->first();

        $old_payment_type = $order->payment_type;

        $order->update([
            'order_number' => $request->input('order_number'),
            'supplier_id'  => $request->input('supplier_id'),
            'total_price'  => 0,
            'quantity'     => count($request->input('addmore')),
            'payment_type' => $request->input('payment_type')
        ]);

        array_filter($request->input('addmore'));

        if($request->input('update_stock')):
            $Invoice_Items=InvoiceItems::where('invoice_id',$order->id)->get();
            foreach($Invoice_Items as $Invoice_Item):
                $product = Product::where('id', $Invoice_Item->product_id)->first();
                $stock   = Stock::where('product_id',$product->id)->first();
                $stock->quantity -= $Invoice_Item->qty;
                $stock->save();
            endforeach;
        endif;

        $order->invoice_items()->delete();

        foreach($request->input('addmore') as $value):
            $product = Product::with('stock')->where('id', $value['product_id'])->first();
            if(!isset($value['price'])):
                $value['price'] =  $product->stock->sale_price;
            endif;

            if(!isset($value['qty'])):
                $value['qty'] =  1;
            endif;

            $order->invoice_items()->create($value);

            if($request->input('update_stock')):
                $stock = Stock::where('product_id',$product->id)->first();
                $stock->quantity += $value['qty'];
                $stock->save();
            endif;
        endforeach;

        if($order->invoice_items()->count() == count($request->input('addmore'))):
            $order->update([
                'total_price' => $order->invoice_items()->sum(DB::raw("(invoice_items.qty * invoice_items.price)")),
                'quantity'    => $order->invoice_items()->count()
            ]);

            if(($old_payment_type !=  $request->input('payment_type')) || (!$order->invoice_payments()->exists()) || ($request->has('payment_value')) ):
                PaymentService::create_supplier_payments_by_invoice($order,$request->input('payment_value'));
            endif;

        else:
            $order->delete();
        endif;
        return redirect()->back()->with('success_message', 'تم اضافة طلب');
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = PurchasingInvoice::find($id);
        $order->invoice_items()->delete();
        $order->delete();
        return redirect()->route('admin.purchasing-invoices.index');

    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order     = PurchasingInvoice::with('invoice_items','invoice_items.product','supplier')->where('id',$id)->first();
        return view(config('app.theme').'.pages.purchasing-invoice.show', compact('order'));

    }
}
