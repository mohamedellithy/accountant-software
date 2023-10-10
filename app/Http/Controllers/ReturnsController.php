<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StakeHolder;
use Illuminate\Http\Request;
use App\Models\CustomerReturn;
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
        $customerReturns = CustomerReturn::query();
        $customerReturns = $customerReturns->with('customer', 'returnitems', 'returnitems.product');
        $per_page = 10;


        $customerReturns->when(request('search') != null, function ($q) {
            return $q->where('order_number', 'like', '%' . request('search') . '%')->orWhereHas('customer', function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            });
        });

        $customerReturns->when(request('filter') == 'high-price', function ($q) {
            return $q->orderBy('total_price', 'asc');
        },function ($q) {
            return $q->orderBy('total_price', 'desc');
        });

        if ($request->has('rows')):
            $per_page = $request->query('rows');
        endif;

        $customerReturns = $customerReturns->paginate($per_page);
        return view(config('app.theme').'.pages.return.index', compact('customerReturns'));
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
         $request->validate([
            'addmore.*.product_id' => 'required',
            'addmore.*.quantity'        => ['required', 'numeric'],
            'addmore.*.price'      => ['required', 'numeric']
        ]);

        $customerReturn = CustomerReturn::Create([
            'order_number' => $request->input('order_number'),
            'customer_id'  => $request->input('customer_id'),
            'total_price'  => 0,
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
                $product->stock->quantity +=  $value['quantity'];
            endif;

        endforeach;

        if($customerReturn->returnitems()->count() == count($request->input('addmore'))):
            $customerReturn->update([
                'total_price' => $customerReturn->returnitems()->sum(DB::raw("(return_items.quantity * return_items.price)")),
            ]);
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
        $customerReturn     = CustomerReturn::with('returnitems','returnitems.product','customer')->where('id',$id)->first();

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
        $customerReturn     = CustomerReturn::with('returnitems')->where('id',$id)->first();
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
            'addmore.*.quantity'        => ['required', 'numeric'],
            'addmore.*.price'      => ['required', 'numeric']
        ]);

        $customerReturn = CustomerReturn::where([
            'id' => $id
        ])->first();

        $customerReturn->update([
            'order_number' => $request->input('order_number'),
            'customer_id'  => $request->input('customer_id'),
            'total_price'  => 0,
        ]);

        array_filter($request->input('addmore'));

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
                $product->stock->quantity +=  $value['quantity'];
            endif;


        endforeach;

        if($customerReturn->returnitems()->count() == count($request->input('addmore'))):
            $customerReturn->update([
                'total_price' => $customerReturn->returnitems()->sum(DB::raw("(return_items.quantity * return_items.price)")),

            ]);
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
        $order = CustomerReturn::find($id);
        $order->returnitems()->delete();
        $order->delete();
        return redirect()->route('admin.return.index');
    }
}
