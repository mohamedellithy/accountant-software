<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StakeHolder;
use Illuminate\Http\Request;
use App\Http\Requests\StockRequest;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stocks = Stock::query();

        $stocks = $stocks->with('product','supplier');

        $per_page = request('rows') ?: 20;
        if(request('search') != null):
            $stocks = $stocks->orWhereHas('supplier', function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })->orWhereHas('product', function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            });
        endif;

        if(request('filter') != null):
            if (request('filter') == 'high-price'):
                $stocks = $stocks->orderBy('sale_price', 'desc');
            elseif (request('filter') == 'low-price'):
                $stocks = $stocks->orderBy('sale_price', 'asc');
            endif;
        else:
            $stocks->orderBy('id', 'desc');
        endif;


        $stocks  = $stocks->paginate($per_page);
        $suppliers = StakeHolder::all();
        $products  = Product::all();
        return view(config('app.theme').'.pages.stock.index', compact('stocks','suppliers','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockRequest $request)
    {
        Stock::create($request->only([
            'product_id',
            'quantity',
            'sale_price',
            'purchasing_price',
            'supplier_id'
        ]));
        return redirect()->back()->with('success_message', 'تم اضافة صنف');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stock = Stock::find($id);
        return view(config('app.theme').'.pages.stock.show', compact('stock'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $suppliers = StakeHolder::all();
        $stock   = Stock::find($id);
        return response()->json([
            'status' => true,
            'view'   => view(config('app.theme').'.pages.stock.model.edit', compact('stock', 'suppliers'))->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StockRequest $request, $id)
    {
        $stock = Stock::where('id', $id)->update($request->only([
            'product_id',
            'quantity',
            'price',
            'supplier_id',
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
        $stock = Stock::find($id);
        $stock = Stock::destroy($id);

        return redirect()->back();

    }
}
