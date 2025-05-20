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

        $data = $request->all();
        $orders->when(isset($data['filter']) && isset($data['filter']['sort']) && ($data['filter']['sort'] == 'sort_asc'), function ($q) {
            return $q->orderBy('created_at', 'asc');
        },function ($q) {
            return $q->orderBy('created_at', 'desc');
        });

        $orders->when(isset($data['filter']) && isset($data['filter']['supplier_id']), function ($q) use($data) {
            return $q->where('supplier_id',$data['filter']['supplier_id']);
        });


        if ($request->has('rows')):
            $per_page = $request->query('rows');
        endif;

        $orders = $orders->paginate($per_page);
        $suppliers = StakeHolder::select('id','name')->orderBy('name', 'asc')->get();

        return view(config('app.theme').'.pages.purchasing-invoice.index', compact('orders','suppliers'));

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
            'addmore.*.price'      => ['required', 'numeric'],
            'supplier_id'          => ['required']
        ]);

        DB::beginTransaction();
        $order = PurchasingInvoice::Create([
            'order_number' => $request->input('order_number'),
            'supplier_id'  => $request->input('supplier_id'),
            'total_price'  => 0,
            'quantity'     => count($request->input('addmore')),
            'payment_type' => $request->input('payment_type'),
            'update_stock' => $request->input('update_stock') ?: '0'
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
                    $stock->purchasing_price = $value['price'];
                    $stock->sale_price       = $value['price'] + 20;
                    $stock->supplier_id      = $request->input('supplier_id');
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
            DB::commit();
        else:
            //$order->delete();
            DB::rollback();
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
            'addmore.*.price'      => ['required', 'numeric'],
            'supplier_id'          => ['required']
        ]);

        DB::beginTransaction();
        $order = PurchasingInvoice::where([
            'id' => $id
        ])->first();

        $old_payment_type = $order->payment_type;

        array_filter($request->input('addmore'));

        if($order->update_stock == '1'):
            $Invoice_Items=InvoiceItems::where('invoice_id',$order->id)->get();
            foreach($Invoice_Items as $Invoice_Item):
                $product = Product::where('id', $Invoice_Item->product_id)->first();
                $stock   = Stock::where('product_id',$product->id)->first();
                $stock->quantity -= $Invoice_Item->qty;
                $stock->save();
            endforeach;
        endif;

        $order->invoice_items()->delete();
        $order->update([
            'order_number' => $request->input('order_number'),
            'supplier_id'  => $request->input('supplier_id'),
            'total_price'  => 0,
            'quantity'     => count($request->input('addmore')),
            'payment_type' => $request->input('payment_type'),
            'update_stock' => $request->input('update_stock') ?: '0'
        ]);
       
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
                $stock->purchasing_price  = $value['price'];
                $stock->sale_price        = $value['price'] + 20;
                $stock->supplier_id      = $request->input('supplier_id');
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
            DB::commit();
        else:
            //$order->delete();
            DB::rollback();
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
        try{
            DB::beginTransaction();
            $order = PurchasingInvoice::find($id);
            $order->invoice_items()->delete();
            $order->delete();
            DB::commit();
        } catch(Exception $e){
            DB::rollback();
        }
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
