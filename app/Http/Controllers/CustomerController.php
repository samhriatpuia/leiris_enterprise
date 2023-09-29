<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Item;

class CustomerController extends Controller
{
    public function dashboard()
    {
        
        // $expiryDate = now()->addDays(30);

        // $items = Item::where('expiry_date', '<=', $expiryDate)
        //              ->paginate(5);

        // return Inertia::render('Dashboard',compact('items'));
        return Inertia::render('Dashboard');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')
                        ->paginate(10);
        return Inertia::render('Customer/Index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Customer/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'gst' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'bank_account' => 'required',
            'bank_ifsc' => 'required',
            'bank_name' => 'required',
            'bank_branch' => 'required',

        ]);
        // dd($request->name);
        Customer::create([
            'name' => $request->name,
            'gst' => $request->gst,
            'address' => $request->address,
            'phone' => $request->phone,
            'bank_account' => $request->bank_account,
            'bank_ifsc' => $request->bank_ifsc,
            'bank_name' => $request->bank_name,
            'bank_branch' => $request->bank_branch,
        ]);
        sleep(1);

        return redirect()->route('customers.index')->with('message', 'Group Created Successfully');

    

   
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
        $customer=Customer::findOrFail($id);
        // dd($customer);
        return Inertia::render('Customer/Edit',compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // dd("HI");
        $customer=Customer::findOrFail($request->id);
        $request->validate([
            'name' => 'required',
            'gst' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'bank_account' => 'required',
            'bank_ifsc' => 'required',
            'bank_name' => 'required',
            'bank_branch' => 'required',

        ]);

       
        $customer->name = $request->name;
        $customer->gst = $request->gst;
        $customer->address = $request->address;
        $customer->phone = $request->phone;
        $customer->bank_account = $request->bank_account;
        $customer->bank_ifsc = $request->bank_ifsc;
        $customer->bank_name = $request->bank_name;
        $customer->bank_branch = $request->bank_branch;
       
        $customer->save();
        

        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer=Customer::findOrFail($id);

        $customer->delete();

        return redirect()->route('customers.index');
    }
    


    public function search(Request $request)
    {
        // dd($request->search_data);
        $customers=Customer::where('name','like', '%' .$request->search_data. '%')->orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Customer/Index',compact('customers'));
        
    }
}
