<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StakeHolder;
use Illuminate\Http\Request;
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
        $orders = $orders->with('supplier', 'invoice_items', 'invoice_items.product');
        $per_page = 10;

        $orders->when(request('search') != null, function ($q) {
            return $q->where('order_number', 'like', '%' . request('search') . '%')->orWhereHas('supplier', function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            });
        });

        $orders->when(request('filter') == 'sort_asc', function ($q) {
            return $q->orderBy('created_at', 'asc');
        },function ($q) {
            return $q->orderBy('created_at', 'desc');
        });

        if ($request->has('rows')):
            $per_page = $request->query('rows');
        endif;

        $orders = $orders->paginate($per_page);
        return view(config('app.theme').'.pages.purchasing-invoice.index', compact('orders'));

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
        $products  = Product::whereHas('stock')->get();
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
            'quantity'     => count($request->input('addmore'))
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
                $product->stock->quantity +=  $value['quantity'];
            endif;

        endforeach;

        if($order->invoice_items()->count() == count($request->input('addmore'))):
            $order->update([
                'total_price' => $order->invoice_items()->sum(DB::raw("(invoice_items.qty * invoice_items.price)")) ,
                'quantity' => $order->invoice_items()->count()
            ]);
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

        $order->update([
            'order_number' => $request->input('order_number'),
            'supplier_id'  => $request->input('supplier_id'),
            'total_price'  => 0,
            'quantity'     => count($request->input('addmore')),

        ]);

        array_filter($request->input('addmore'));

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
                $product->stock->quantity +=  $value['quantity'];
            endif;
        endforeach;

        if($order->invoice_items()->count() == count($request->input('addmore'))):
            $order->update([
                'total_price' => $order->invoice_items()->sum(DB::raw("(invoice_items.qty * invoice_items.price)")),
                'quantity'    => $order->invoice_items()->count()
            ]);
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