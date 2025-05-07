<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StakeHolder;
use Illuminate\Http\Request;
use App\Http\Requests\StockRequest;
use Illuminate\Support\Facades\DB;

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
        $filter_data = $request->all();
        $stocks->when(isset($filter_data['filter']) && isset($filter_data['filter']['product_id']),function($query) use($filter_data){
            $query->whereHas('product', function ($query) use($filter_data){
                $query->where('id',$filter_data['filter']['product_id']);
            });
        })->when(isset($filter_data['filter']) && isset($filter_data['filter']['supplier_id']),function($query) use($filter_data){
            $query->whereHas('supplier', function ($query) use($filter_data){
                $query->where('id',$filter_data['filter']['supplier_id']);
            });
        })->when(
            isset($filter_data['filter']) && isset($filter_data['filter']['price']),
            function($query) use($filter_data){
                if($filter_data['filter']['price'] == 'high-price'){
                    $query->orderBy('sale_price', 'desc');
                } elseif($filter_data['filter']['price'] == 'low-price') {
                    $query->orderBy('sale_price', 'asc');
                }
            },
            function($query){
                $query->orderBy('id', 'desc');
            }
        );
        $stocks  = $stocks->paginate($per_page);
        $suppliers = StakeHolder::select('id','name')->get();
        $products  = Product::select('id','name')->get();
        $statics_for_product = null;
        if(isset($filter_data['filter']) && isset($filter_data['filter']['product_id'])){
            $statics_for_product = Product::where('products.id',$filter_data['filter']['product_id'])
            ->leftJoin('stocks','products.id','=','stocks.product_id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(stocks.quantity) as total_qty'),
                DB::raw('SUM(stocks.quantity * stocks.purchasing_price) as total_cost_purchasing'),
                DB::raw('SUM(stocks.quantity * stocks.sale_price) as total_must_profit'),
                DB::raw('COUNT(stocks.supplier_id) as suppliers_count')
            )->groupBy('products.id')->first();
        }
        return view(config('app.theme').'.pages.stock.index', compact('stocks','suppliers','products','statics_for_product'));
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
        $products  = Product::all();
        return response()->json([
            'status' => true,
            'view'   => view(config('app.theme').'.pages.stock.model.edit', compact('stock', 'suppliers','products'))->render()
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
            'sale_price',
            'purchasing_price',
            'supplier_id'
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
