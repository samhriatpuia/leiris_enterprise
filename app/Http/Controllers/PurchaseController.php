<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::orderBy('created_at', 'desc')
                        ->paginate(10);
        return Inertia::render('Purchase/Index',compact('purchases'));
    }


    public function search(Request $request)
    {
        // dd($request->search_data);
        $purchases=Purchase::where('invoice_number','like', '%' .$request->search_data. '%')->orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Purchase/Index',compact('purchases'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $customers=Customer::pluck('name','id');
        return Inertia::render('Purchase/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->customer_id);
        $request->validate([
            'date' => 'required',
            'invoice_number' => 'required',
            'logistic_charge' => 'required',
            'handling_charge' => 'required',
           
           
            'vendor'=>'required',

        ]);
        // dd($request->name);
        
        Purchase::create([
            'vendor' => $request->vendor,
            'date' => $request->date,
            'invoice_number' => $request->invoice_number,
            'logistic_charge' => $request->logistic_charge,
            'handling_charge' => $request->handling_charge,
            'discount' => $request->discount,
            'scheme' => $request->scheme,
        ]);
        
        

        return redirect()->route('purchases.index')->with('message', 'Purchase Created Successfully');

    

   
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $purchase=Purchase::findOrFail($id);
        return Inertia::render('Purchase/Edit',compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $purchase=Purchase::findOrFail($request->id);
        
        $request->validate([
            'vendor' => 'required',
            'date' => 'required',
            'invoice_number' => 'required',
            'logistic_charge' => 'required',
            'handling_charge' => 'required',
            
            // 'sub_total' => 'required',

        ]);
        

        $purchase->vendor = $request->vendor;
        $purchase->date = $request->date;
        $purchase->invoice_number = $request->invoice_number;
        $purchase->logistic_charge = $request->logistic_charge;
        $purchase->handling_charge = $request->handling_charge;
        $purchase->discount = $request->discount;
        $purchase->scheme = $request->scheme;
       
        $purchase->save();

        return redirect()->route('purchases.index');
    }


    public function invoiceIndex($id)
    {
        $purchase=Purchase::findOrFail($id);
        
        $purchaseDetails=PurchaseDetail::where('purchase_id',$purchase->id)->paginate(10);
        
        return Inertia::render('Purchase/Invoice',compact('purchase','purchaseDetails'));
    }


    public function invoiceStore(Request $request)
    {

        $request->validate([
            'particulars' => 'required',
            'unit'=>'required',
            'quantity'=>'required',
            // 'discount'=>'required',
            // 'amount'=>'required',
            'price'=>'required',
            
        ]);

       
        PurchaseDetail::create([
            'particulars' => $request->particulars,
            'quantity' => $request->quantity,
            'unit'=>$request->unit,
            'price'=>$request->price,
            'discount'=>$request->discount,
            'amount'=>($request->price*$request->quantity)-($request->discount),
            'purchase_id'=>$request->purchase_id,
        ]);


        $purchase=Purchase::where('id',$request->purchase_id)->first();
        
        $purchaseDetail=PurchaseDetail::where('purchase_id',$purchase->id)->get();

        $purchase->sub_total=0;

        foreach($purchaseDetail as $detail)
        {
            $purchase->sub_total=$purchase->sub_total+$detail->amount;
        }

        

        $purchase->grand_total=$purchase->sub_total+$purchase->logistic_charge+$purchase->handling_charge-$purchase->discount;
        
       
        $purchase->save();

        // dd($sale->sub_total);
        $purchaseDetails=PurchaseDetail::where('purchase_id',$purchase->id)->paginate(10);
        return Inertia::render('Purchase/Invoice',compact('purchase','purchaseDetails'));
    }



    public function destroyPurchaseDetails($id)
    {
        // dd("HER");
        $purchaseDetail=PurchaseDetail::findOrFail($id);

        $purchase=Purchase::where('id',$purchaseDetail->purchase_id)->first();
        
        // $details1=Detail::where('sales_id',$sale->id)->get();

        $purchase->sub_total=$purchase->sub_total-$purchaseDetail->amount;

        $purchase->grand_total=$purchase->grand_total-$purchaseDetail->amount;

        $purchaseDetail->delete();
       
        $purchase->save();
        
        $purchaseDetails=PurchaseDetail::where('purchase_id',$purchase->id)->paginate(10);
        
        return Inertia::render('Purchase/Invoice',compact('purchase','purchaseDetails'));
    }


    public function destroy($id)
    {
        $purchase=Purchase::findOrFail($id);

        $purchase->delete();

        return redirect()->route('purchases.index')->with('message', 'Purchase Deleted Successfully');
    }
}
