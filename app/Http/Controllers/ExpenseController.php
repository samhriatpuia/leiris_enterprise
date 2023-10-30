<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::orderBy('created_at', 'desc')
        ->paginate(10);


        return Inertia::render('Expenses/Index',compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Expenses/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'particular' => 'required',
            'amount' => 'required',
            'date'=>'required',
           
        ]);
        // dd($request->remarks);
        $expense=new Expense;

        $expense->particular=$request->particular;
        $expense->amount=$request->amount;
        $expense->date=$request->date;
        $expense->remarks= $request->remarks;
        $expense->save();
        // Expense::create([
        //     'particular' => $request->particular,
        //     'amount' => $request->amount,
        //     'date' => $request->date,
        //     'remarks' => $request->remarks,
        // ]);
        sleep(1);

        $expenses = Expense::orderBy('created_at', 'desc')->paginate(10);

        return redirect()->route('expenses.index',compact('expenses'))->with('message', 'Expense Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $expense=Expense::findOrFail($id);


        return Inertia::render('Expenses/Edit',compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $expense=Expense::findOrFail($request->id);
        $request->validate([
            'particular' => 'required',
            'amount' => 'required',
            'date'=>'required',
        ]);

       
        $expense->particular = $request->particular;
        $expense->amount = $request->amount;
        $expense->date = $request->date;
        $expense->remarks = $request->remarks;
        
       
        $expense->save();
        
        
        $expenses = Expense::orderBy('created_at', 'desc')->paginate(10);

        return redirect()->route('expenses.index',compact('expenses'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $expense=Expense::findOrFail($id);

        $expense->delete();

        $expenses = Expense::orderBy('created_at', 'desc')->paginate(10);

        return redirect()->route('expenses.index',compact('expenses'));
    }
}
