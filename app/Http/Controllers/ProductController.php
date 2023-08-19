<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
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

        $per_page = 10;
        if ($request->has('search')) {
            $products = $products->where('name', 'like', '%' . request('search') . '%')->orWhereHas('supplier', function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            });

            if ($request->has('filter')):
                if ($request->query('filter') == 'high-price'):
                    $products = $products->orderBy('price', 'desc');
                elseif ($request->query('filter') == 'low-price'):
                    $products = $products->orderBy('price', 'asc');
                endif;
            else:
                $products = $products->orderBy('id', 'desc');
            endif;

        }
        if ($request->has('rows')) {
            $per_page = $request->query('rows');
        }

        $products = $products->paginate($per_page);
        return view('pages.admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        { $suppliers = Supplier::all();

            return view('pages.admin.product.create', compact('suppliers'));

        }

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
            'name',
            'quantity',
            'price',
            'supplier_id',

        ]));
        return redirect()->route('products.index')->with('success_message', 'تم اضافة صنف');

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
        return view('pages.admin.product.show', compact('product'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {$suppliers = Supplier::all();

        $product = Product::find($id);
        return view('pages.admin.product.edit', compact('product', 'suppliers'));

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
            'name',
            'quantity',
            'price',
            'supplier_id',
        ]));
        return redirect()->route('products.index');

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

        return redirect()->route('products.index');

    }
}
