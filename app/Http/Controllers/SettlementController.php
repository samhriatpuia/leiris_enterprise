<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Settlement;
use App\Models\Sale;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
       
        $settlements=Settlement::where('sales_id',$id)->orderBy('created_at', 'desc')->paginate(10);
        // dd($id);
        $sale=Sale::findOrFail($id);
        return Inertia::render('Settlement/Index',compact('settlements','sale'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payer' => 'required',
            'mode'=>'required',
            'transaction_id'=>'required',
            'amount'=>'required|numeric',
            'sales_id'=>'required',
            
        ]);

        $sale=Sale::findOrFail($request->sales_id);
        $allSettlements=Settlement::where('sales_id',$request->sales_id)->get();

        $allPaid=$request->amount;
        foreach($allSettlements as $allSettlement)
        {
            $allPaid=$allPaid+$allSettlement->amount;
        }

        // dd($allPaid);
        $balance=$sale->grand_total-$allPaid;

        Settlement::create([
            'payer' => $request->payer,
            'mode' => $request->mode,
            'transaction_id'=>$request->transaction_id,
            'amount'=>$request->amount,
            'sales_id'=>$request->sales_id,
            'grand_total'=>$sale->grand_total,
            'balance'=>$balance,
        ]);


        $settlements=Settlement::where('sales_id',$request->sales_id)->orderBy('created_at', 'desc')->paginate(10);
      
        
        return redirect()->route('settlements.index',$request->sales_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Settlement $settlement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settlement $settlement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Settlement $settlement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settlement $settlement)
    {
        //
    }
}
