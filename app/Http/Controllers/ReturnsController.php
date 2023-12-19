<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use App\Models\ReturnItem;
use App\Models\ReturnsPayment;
use App\Models\StakeHolder;
use Illuminate\Http\Request;
use App\Models\Returned;
use Illuminate\Support\Facades\DB;

class ReturnsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customerReturns = Returned::query();
        $customerReturns = $customerReturns->with('customer', 'returnitems', 'returnitems.product');
        $per_page = 10;


        $customerReturns->when(request('search') != null, function ($q) {
            return $q->where('order_number', 'like', '%' . request('search') . '%')->orWhereHas('customer', function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            });
        });


        if ($request->has('from') and $request->has('to') and $request->get('from') != "" and $request->get('to') != "") {
            $from=$request->get('from');
            $to=$request->get('to');

            $customerReturns->whereBetween('created_at',[$from,$to]);
        }

        if ($request->has('customer_filter') and $request->get('customer_filter') != "") {

            $customerReturns->where('customer_id',$request->get('customer_filter'));
        }

        $customerReturns->when(request('filter') == 'high-price', function ($q) {
            return $q->orderBy('total_price', 'desc');
        },function ($q) {
            return $q->orderBy('total_price', 'asc');
        });

        if ($request->has('rows')):
            $per_page = $request->query('rows');
        endif;

        $customerReturns = $customerReturns->paginate($per_page);
        $customers = StakeHolder::select('id','name')->orderBy('name', 'asc')->get();
        return view(config('app.theme').'.pages.return.index', compact('customerReturns','customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = StakeHolder::select('id','name')->get();
        $products  = Product::whereHas('stock')->get();
        return view(config('app.theme').'.pages.return.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'addmore.*.product_id' => 'required',
            'addmore.*.quantity'        => ['required', 'numeric'],
            'addmore.*.price'      => ['required', 'numeric'],
            'type_return_bill'          => 'required'
        ]);

        $customerReturn = Returned::Create([
            'order_number'     => $request->input('order_number'),
            'customer_id'      => $request->input('customer_id'),
            'total_price'      => 0,
            'type_return'      => $request->input('type_return_bill')
        ]);

        array_filter($request->input('addmore'));

        foreach($request->input('addmore') as $value):
            $product = Product::with('stock')->where('id', $value['product_id'])->first();
            if(!isset($value['price'])):
                $value['price'] =  $product->stock->price;
            endif;

            if(!isset($value['quantity'])):
                $value['quantity'] =  1;
            endif;


            $customerReturn->returnitems()->create($value);

            if($request->input('update_stock')):
                $stock = Stock::where('product_id',$product->id)->first();
                if($request->input('type_return_bill') == 'sale'):
                    $stock->quantity += $value['quantity'];
                else:
                    $stock->quantity -= $value['quantity'];
                endif;
                $stock->save();
            endif;

        endforeach;

        if($customerReturn->returnitems()->count() == count($request->input('addmore'))):
            $customerReturn->update([
                'total_price' => $customerReturn->returnitems()->sum(DB::raw("(return_items.quantity * return_items.price)")),
            ]);

            // ReturnsPayment::create([
            //     'stake_holder_id' => $request->input('customer_id'),
            //     'r_invoice_id'    => $customerReturn->id,
            //     'value'           => $customerReturn->total_price,
            //     'type_return'     => $request->input('type_return_bill')
            // ]);

        else:
            $customerReturn->delete();
        endif;
        return redirect()->route('admin.returns.index')->with('success_message', 'تم اضافة مرتجع');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customerReturn     = Returned::with('returnitems','returnitems.product','customer')->where('id',$id)->first();

        return view(config('app.theme').'.pages.return.show', compact('customerReturn'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customerReturn     = Returned::with('returnitems')->where('id',$id)->first();
        $customers = StakeHolder::select('id','name')->get();
        $products  = Product::all();
        return view(config('app.theme').'.pages.return.edit', compact('customerReturn','customers','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'addmore.*.product_id' => 'required',
            'addmore.*.quantity'   => ['required', 'numeric'],
            'addmore.*.price'      => ['required', 'numeric'],
            'type_return_bill'     => 'required'
        ]);

        $customerReturn = Returned::where([
            'id' => $id
        ])->first();

        $customerReturn->update([
            'order_number' => $request->input('order_number'),
            'customer_id'  => $request->input('customer_id'),
            'total_price'  => 0,
            'type_return'  => $request->input('type_return_bill')
        ]);

        array_filter($request->input('addmore'));



        if($request->input('update_stock')):

            $Return_Items=ReturnItem::where('return_id',$customerReturn->id)->get();

            foreach($Return_Items as $Return_Item):
                $product = Product::with('stock')->where('id', $Return_Item->product_id)->first();
                $stock = Stock::where('product_id',$product->id)->first();

                if($customerReturn->type_return == 'sale'):
                    $stock->quantity -= $Return_Item->quantity;
                else:
                    $stock->quantity += $Return_Item->quantity;
                endif;
                $stock->save();
            endforeach;
        endif;

        $customerReturn->returnitems()->delete();

        foreach($request->input('addmore') as $value):
            $product = Product::with('stock')->where('id', $value['product_id'])->first();
            if(!isset($value['price'])):
                $value['price'] =  $product->stock->sale_price;
            endif;

            if(!isset($value['quantity'])):
                $value['quantity'] =  1;
            endif;

            $customerReturn->returnitems()->create($value);
            if($request->input('update_stock')):
                $stock = Stock::where('product_id',$product->id)->first();
                if($request->input('type_return_bill') == 'sale'):
                    $stock->quantity += $value['quantity'];
                else:
                    $stock->quantity -= $value['quantity'];
                endif;
                $stock->save();

            endif;

        endforeach;

        if($customerReturn->returnitems()->count() == count($request->input('addmore'))):
            $customerReturn->update([
                'total_price' => $customerReturn->returnitems()->sum(DB::raw("(return_items.quantity * return_items.price)")),

            ]);

            // ReturnsPayment::where([
            //     'r_invoice_id'    => $customerReturn->id,
            // ])->update([
            //     'stake_holder_id' => $request->input('customer_id'),
            //     'value'           => $customerReturn->total_price,
            //     'type_return'     => $request->input('type_return_bill')
            // ]);

        else:
            $customerReturn->delete();
        endif;
        return redirect()->back()->with('success_message', 'تم تعديل المرتجع');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Returned::find($id);
        $order->returnitems()->delete();
        $order->delete();
        return redirect()->route('admin.return.index');
    }
}
