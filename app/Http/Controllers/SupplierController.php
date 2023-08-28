<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::query();

        $per_page = 10;
        if ($request->has('search')) {
            $suppliers = $suppliers->where('name', 'like', '%' . $request->query('search') . '%');
        }
        if ($request->has('rows')) {
            $per_page = $request->query('rows');
        }

        $suppliers = $suppliers->paginate($per_page);
        return view('pages.admin.supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {

        Supplier::create($request->only([
            'name',
            'phone',

        ]));
        return redirect()->route('suppliers.index')->with('success_message', 'تم اضافة مزود');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Supplier::find($id);
        return view('pages.admin.supplier.show', compact('supplier'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view('pages.admin.supplier.edit', compact('supplier'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, $id)
    {
        $supplier = Supplier::where('id', $id)->update($request->only([
            'name',
            'phone',
        ]));
        return redirect()->route('suppliers.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier = Supplier::destroy($id);

        return redirect()->route('suppliers.index');

    }
    public function supplierProduct($id)
    {
        $supplierproducts = supplier::where('id', $id)->with('products')->first();
        return view('pages.admin.supplier.supplierproduct', compact('supplierproducts'));

    }
}
