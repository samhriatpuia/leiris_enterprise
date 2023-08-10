<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Inertia\Inertia;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Detail;
use App\Models\Item;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::orderBy('created_at', 'desc')
                        ->paginate(10);
        return Inertia::render('Sales/Index',compact('sales'));
    }


    public function search(Request $request)
    {
        // dd($request->search_data);
        $sales=Sale::where('customer_name','like', '%' .$request->search_data. '%')->orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Sales/Index',compact('sales'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers=Customer::pluck('name','id');
        return Inertia::render('Sales/Create',compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->customer_id);
        $request->validate([
            'customer_id' => 'required',
            'date' => 'required',
            'invoice_number' => 'required',
            'logistic_charge' => 'required',
            'handling_charge' => 'required',
            'discount' => 'required',
            'scheme' => 'required',
            // 'sub_total' => 'required',

        ]);
        // dd($request->name);
        $customer=Customer::findOrFail($request->customer_id);
        Sale::create([
            'customer_id' => $request->customer_id,
            'date' => $request->date,
            'invoice_number' => $request->invoice_number,
            'logistic_charge' => $request->logistic_charge,
            'handling_charge' => $request->handling_charge,
            'discount' => $request->discount,
            'scheme' => $request->scheme,

            'customer_name' => $customer->name,
            // 'bank_branch' => $request->bank_branch,
        ]);
        

        return redirect()->route('sales.index')->with('message', 'Sales Created Successfully');

    

   
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
        $sale=Sale::findOrFail($id);
        $customers=Customer::pluck('name','id');
        return Inertia::render('Sales/Edit',compact('sale','customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $sale=Sale::findOrFail($request->id);
        $request->validate([
            'customer_id' => 'required',
            'date' => 'required',
            'invoice_number' => 'required',
            'logistic_charge' => 'required',
            'handling_charge' => 'required',
            'discount' => 'required',
            'scheme' => 'required',
            // 'sub_total' => 'required',

        ]);
        $customer=Customer::findOrFail($request->customer_id);

        $sale->customer_id = $request->customer_id;
        $sale->date = $request->date;
        $sale->invoice_number = $request->invoice_number;
        $sale->logistic_charge = $request->logistic_charge;
        $sale->handling_charge = $request->handling_charge;
        $sale->discount = $request->discount;
        $sale->scheme = $request->scheme;

        $sale->customer_name = $customer->name;
       
        $sale->save();
        

        return redirect()->route('sales.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }


    public function invoiceIndex($id)
    {
        $sale=Sale::findOrFail($id);
        // dd($sale->id);
        $customer=Customer::where('id',$sale->customer_id)->first();
        // dd($customer->id);
        $details=Detail::where('sales_id',$sale->id)->paginate(10);
        $items=Item::pluck('name','id');
        return Inertia::render('Sales/Invoice',compact('customer','sale','details','items'));
    }


    public function invoiceStore(Request $request)
    {

        $request->validate([
            'particulars' => 'required',
            'quantity'=>'required',
        ]);

        $item=Item::where('id',$request->particulars)->first();
        // dd($request->sales_id);
        Detail::create([
            'particulars' => $item->name,
            'quantity' => $request->quantity,
            'unit'=>$item->units_main,
            'price'=>$item->selling_price,
            'amount'=>($item->selling_price*$request->quantity),
            'sales_id'=>$request->sales_id,
        ]);


        $sale=Sale::where('id',$request->sales_id)->first();

        $details1=Detail::where('sales_id',$sale->id)->get();

        $sale->sub_total=0;

        foreach($details1 as $detail)
        {
            $sale->sub_total=$sale->sub_total+$detail->amount;
        }

        

        $sale->grand_total=$sale->sub_total+$sale->logistic_charge+$sale->handling_charge-$sale->discount;
       
        $sale->save();

        // dd($sale->sub_total);
        $customer=Customer::where('id',$sale->customer_id)->first();
        $details=Detail::where('sales_id',$sale->id)->paginate(10);
        $items=Item::pluck('name','id');
        return Inertia::render('Sales/Invoice',compact('customer','sale','details','items'));
    }
}
