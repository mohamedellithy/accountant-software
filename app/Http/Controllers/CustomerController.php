<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\StakeHolder;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = StakeHolder::query();

        $customers = $customers->where('role','customer');

        $customers = $customers->orWhereHas('orders');

        $customers = $customers->withCount('orders');

        $customers = $customers->withSum('orders','total_price');

        $per_page = 10;
        if ($request->has('search')) {
            $customers = $customers->where('name', 'like', '%' . $request->query('search') . '%');
        }
        if ($request->has('rows')) {
            $per_page = $request->query('rows');
        }

        $customers = $customers->paginate($per_page);

        return view(config('app.theme').'.pages.customer.index', compact('customers'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $request->merge([
            'role' => 'customer'
        ]);

        StakeHolder::create($request->only([
            'name',
            'phone',
            'role'
        ]));
        return redirect()->back()->with('success_message', 'تم اضافة عميل');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $customer = StakeHolder::with('orders')->withCount('orders')->withSum('orders','total_price')->find($id);
        $orders   = Order::query();
        $per_page = 10;
        if ($request->has('search')) {
            $customers = $$orders->where('name', 'like', '%' . $request->query('search') . '%');
        }
        if ($request->has('rows')) {
            $per_page = $request->query('rows');
        }

        $orders   = $orders->where('customer_id',$id)->paginate($per_page);
        return view(config('app.theme').'.pages.customer.show', compact('customer','orders'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $customer   = StakeHolder::find($id);
        return response()->json([
            'status' => true,
            'view'   => view(config('app.theme').'.pages.customer.model.edit', compact('customer'))->render()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $customer = StakeHolder::where('id', $id)->update($request->only([
            'name',
            'phone',
        ]));
        return redirect()->back()->with('success_message', 'تم تعديل عميل');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = StakeHolder::find($id);
        $customer = StakeHolder::destroy($id);

        return redirect()->back()->with('success_message', 'تم حذف العميل');

    }
}
