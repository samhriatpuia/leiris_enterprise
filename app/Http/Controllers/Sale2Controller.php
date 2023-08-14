<?php

namespace App\Http\Controllers;

use App\Models\Sale2;
use App\Models\Customer;
use App\Models\Detail2;
use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Sale2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale2::orderBy('created_at', 'desc')
                        ->paginate(10);
        return Inertia::render('Sales2/Index',compact('sales'));
    }


    public function search(Request $request)
    {
        // dd($request->search_data);
        $sales=Sale2::where('invoice_number','like', '%' .$request->search_data. '%')->orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Sales2/Index',compact('sales'));
        
    }


    public function invoiceIndex($id)
    {
        $sale=Sale2::findOrFail($id);
        // dd($sale->id);
        $customer=Customer::where('id',$sale->customer_id)->first();
        // dd($customer->id);
        $details=Detail2::where('sales_id',$sale->id)->paginate(10);
        $items=Item::pluck('name','id');
        return Inertia::render('Sales2/Invoice',compact('customer','sale','details','items'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale2 $sale2)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale2 $sale2)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale2 $sale2)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale2 $sale2)
    {
        //
    }
}
