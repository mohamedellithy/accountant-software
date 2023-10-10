<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::query();

        $per_page = request('rows') ?: 20;

        $expenses->when(request('search') != null, function ($q) {
            return $q->where('name', 'like', '%' . request('search') . '%')->orWhere(function ($query) {
                $query->where('price', 'like', '%' . request('search') . '%');
            });
        });


        $expenses->orderBy('id', 'desc');

        $expenses = $expenses->paginate($per_page);
        return view(config('app.theme').'.pages.expense.index', compact('expenses'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Expense::create($request->only([
            'name',
            'price'
        ]));
        return redirect()->back()->with('success_message', 'تم اضافة مصروف');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense   = Expense::find($id);
        return response()->json([
            'status' => true,
            'view'   => view(config('app.theme').'.pages.expense.model.edit', compact('expense'))->render()
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
        $expense = Expense::where('id', $id)->update($request->only([
            'name',
            'price'
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
        $expense = Expense::find($id);
        $expense = Expense::destroy($id);
        return redirect()->back();
    }
}
