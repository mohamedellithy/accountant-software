<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::query();
        $orders = $orders->with('customer', 'orderitems', 'orderitems.product');
        $per_page = 10;
        $orders->when(request('order_status') != null, function ($q) {
            return $q->where('order_status', request('order_status'));
        });

        $orders->when(request('search') != null, function ($q) {
            return $q->where('order_no', 'like', '%' . request('search') . '%')->orWhereHas('customer', function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            });
        });

        $orders->when(request('filter') == 'sort_asc', function ($q) {
            return $q->orderBy('created_at', 'asc');
        });

        $orders->when(request('filter') == 'sort_desc', function ($q) {
            return $q->orderBy('created_at', 'desc');
        });

        if ($request->has('rows')):
            $per_page = $request->query('rows');
        endif;

        $orders = $orders->paginate($per_page);
        return view('pages.admin.order.index', compact('orders'));

    }
    public function getPhone($id)
    {
        $data = Customer::where('id', $id)->first();
        return response()->json($data);
    }
    public function getProductPrice($id)
    {
        $product = Product::find($id);

        return response()->json($product);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('pages.admin.order.create', compact('customers', 'products'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $stock=array();
        // foreach ($request->addmore as $item) {
        //     $stock[] = Product::where('id', $item->product_id)->value('quantity');
        // }
        $request->validate([
            'addmore.*.product_id' => 'required',
            'addmore.*.qty' => ['required', 'numeric'],
            'addmore.*.price' => 'required',
        ]);
        $order = Order::Create([
            'order_number' => Str::random(5) . auth()->user()->id,
            'customer_id' => $request->input('customer_id'),
            'total_price' => 0,

            'order_status' => 'pending',
            'discount' => $request->input('discount'),
        ]);

        foreach ($request->addmore as $key => $value) {
            // $value['price'] = Product::where('id', $value['product_id'])->value('price');
            $stock = Product::where('id', $value['product_id'])->value('quantity');
            $productName = Product::where('id', $value['product_id'])->value('name');
            $productPrice = Product::where('id', $value['product_id'])->value('name');

            // if()
            if ($value['qty'] > $stock) {
                flash()->warning('كمية المنتج ' . $productName . 'اكبر من المخزون');
                // return redirect()->back();

            } else {

                $order->orderitems()->create($value);
            }
        }
        if ($order->orderitems()->count() > 0) {

            $order->update([
                'total_price' => $order->orderitems()->get()->reduce(function ($total, $item) {
                    return ($total + ($item->qty * $item->price));
                }) - $order->discount,
                // 'quantity' => $order->orderitems()->count(),

            ]);

        } else {

            $order->delete();
        }
        return redirect()->route('orders.index')->with('success_message', 'تم اضافة طلب');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('id', $id)->with('customer', 'orderitems', 'orderitems.product')->first();
        return view('pages.admin.order.show', compact('order'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        //
        $order = Order::where('id', $id)->update([
            'order_status' => $request->input('order_status'),
        ]);

        $order = Order::where('id', $id)->where('order_status', 'completed')->first();
        if ($order) {
            foreach ($order->orderitems as $item) {
                $product = Product::find($item->product->id);

                if ($product) {
                    $newQuantity = $product->quantity - $item->qty;

                    if ($newQuantity >= 0) {
                        $product->quantity = $newQuantity;
                        $product->save();
                    }
                }
            }
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
