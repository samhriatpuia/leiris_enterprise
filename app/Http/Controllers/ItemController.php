<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::orderBy('created_at', 'desc')
                        ->paginate(2);

       
        return Inertia::render('Items',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups= Group::pluck('name','id');
        return Inertia::render('ItemCreate',compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->name);
        $request->validate([
            'name' => 'required',
            'group' => 'required',
            'gst' => 'required',

            'HSN' => 'required',
            'stock_opening' => 'required',
            'purchase_price' => 'required',
            'selling_price' => 'required',
            'batch_no' => 'required',
            'manufacture_date' => 'required',
            'expiry_date' => 'required',
            'units_main' => 'required',
            'units_secondary' => 'required',
            'units_relation' => 'required',

        ]);
        // dd($request->name);
        Item::create([
            'name' => $request->name,
            'group' => $request->group,
            'gst' => $request->gst,

            'HSN' => $request->HSN,
            'stock_opening' => $request->stock_opening,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'batch_no' => $request->batch_no,
            'manufacture_date' => $request->manufacture_date,
            'expiry_date' => $request->expiry_date,
            'units_main' => $request->units_main,
            'units_secondary' => $request->units_secondary,
            'units_relation' => $request->units_relation,
        ]);
        sleep(1);

        return redirect()->route('items.index')->with('message', 'Item Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }

    public function search(Request $request)
    {
        // dd($request->search_data);
        $items=Item::where('name','like', '%' .$request->search_data. '%')->orderBy('created_at', 'desc')->paginate(2);

        return Inertia::render('Items',['items' => $items]);
        
    }
}
