<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

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
    public function show($id)
    {
        $product = Product::find($id);
        return view(config('app.theme').'.pages.product.show', compact('product'));

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
