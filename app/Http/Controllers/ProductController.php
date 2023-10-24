<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use App\Models\InvoiceItems;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::query();

        $per_page = request('rows') ?: 20;
        if(request('search') != null):
            $products = $products->where('name', 'like', '%' . request('search') . '%');
        endif;

        $products->orderBy('id', 'desc');

        $products = $products->paginate($per_page);
        return view(config('app.theme').'.pages.product.index', compact('products'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        Product::create($request->only([
            'name'
        ]));
        return redirect()->back()->with('success_message', 'تم اضافة صنف');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $per_page    = 10;

        if(request('type') != 'invoices'):
            $product     = Product::withSum('order_items',DB::raw('order_items.price * order_items.qty'))
            ->withSum('order_items','qty');

            $order_items = OrderItem::query();
 
            $order_items = $order_items->whereHas('product',function($q) use($id){
                return $q->where('id',$id);
            })->with('order','order.customer');

            $order_items->when(request('search') != null, function ($q) {
                return $q->WhereHas('order.customer', function ($query) {
                    $query->where('name', 'like', '%' . request('search') . '%');
                })->orWhereHas('order',function($query){
                    $query->where('id', 'like', '%' . request('search') . '%');
                });
            });
        else:
            $product     = Product::withSum('invoice_items',DB::raw('invoice_items.price * invoice_items.qty'))
            ->withSum('invoice_items','qty');
            
            $order_items = InvoiceItems::query();
 
            $order_items = $order_items->whereHas('product',function($q) use($id){
                return $q->where('id',$id);
            })->with('purchasing_invoice','purchasing_invoice.supplier');

            $order_items->when(request('search') != null, function ($q) {
                return $q->WhereHas('purchasing_invoice.supplier', function ($query) {
                    $query->where('name', 'like', '%' . request('search') . '%');
                })->orWhereHas('purchasing_invoice',function($query){
                    $query->where('id', 'like', '%' . request('search') . '%');
                });
            });
        endif;

        $order_items->when(request('filter') == 'sort_asc', function ($q) {
            return $q->orderBy('created_at', 'asc');
        },function ($q) {
            return $q->orderBy('created_at', 'desc');
        });

        if ($request->has('rows')):
            $per_page = $request->query('rows');
        endif;

        $product     = $product->find($id);
        $order_items = $order_items->paginate($per_page);

        //dd($product);

        return view(config('app.theme').'.pages.product.show', compact('product','order_items'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $product   = Product::find($id);
        return response()->json([
            'status' => true,
            'view'   => view(config('app.theme').'.pages.product.model.edit', compact('product'))->render()
        ]);
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
        $product = Product::where('id', $id)->update($request->only([
            'name'
        ]));
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
        $product = Product::find($id);
        $product = Product::destroy($id);
        return redirect()->back();

    }
}
