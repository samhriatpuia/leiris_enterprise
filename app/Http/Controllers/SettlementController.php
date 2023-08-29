<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Settlement;
use App\Models\SettlementDetail;
use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $customers=Customer::orderBy('created_at', 'desc')->paginate(10);
        // dd($id);
        // $sale=Sale::findOrFail($id);
        return Inertia::render('Settlement/Index',compact('customers'));
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
    public function destroy($id)
    {
        // dd("here");
        $settlement=Settlement::findOrFail($id);

        $sale=Sale::findOrFail($settlement->sales_id);
        $settlement->delete();

        return redirect()->route('settlements.index',$sale->id);
    }


    public function settlementDetailsIndex($id)
    {
        
        $theSettlement=Settlement::where('customer_id',$id)->first();
        // dd($theSettlement->id);
        $settlementDetails=SettlementDetail::where('settlement_id',$theSettlement->id)->orderBy('created_at', 'desc')->paginate(10);
        
        return Inertia::render('Settlement/DetailsIndex',compact('settlementDetails','theSettlement'));
    }


    public function settlementDetailsStore(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'mode'=>'required',
            'transaction_id'=>'required',
            'amount'=>'required|numeric',
            'settlement_id'=>'required',
            'recieve_by'=>'required',
            'payer'=>'required',
            
        ]);

        $theSettlement=Settlement::where('id',$request->settlement_id)->first();

        $remaining=0;
        if (SettlementDetail::where('settlement_id', $theSettlement->id)->exists())
        {
            $theSD=SettlementDetail::latest()->first();
            $remaining=$theSD->balance-$request->amount;

        }else{
            $remaining=$theSettlement->grand_total-$request->amount;
        }


        
        SettlementDetail::create([
            'payer' => $request->payer,
            'mode' => $request->mode,
            'transaction_id'=>$request->transaction_id,
            'amount'=>$request->amount,
            'settlement_id'=>$request->settlement_id,
            'grand_total'=>$theSettlement->grand_total,
            'recieve_by'=>$request->recieved_by,
            'balance'=>$remaining,
        ]);

        // dd($request->settlement_id);
        return redirect()->route('settlements.details.index',$request->settlement_id);
    }
}
