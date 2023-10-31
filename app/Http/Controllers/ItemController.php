<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Group;
use App\Models\Batch;
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
                        ->paginate(10);


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
            'gst' => 'required',
            // 'main_selling_price'=> 'required',
            // 'secondary_selling_price'=> 'required',

            'mrp'=> 'required',
            'batch_no'=> 'required',
            // 'HSN'=> 'required',
            'manufacture_date'=> 'required',
            'expiry_date'=> 'required',
            'units_main'=> 'required',
            'main_selling_price'=>'required',
            'main_stock'=>'required',
            'units_secondary'=> 'required',
            'units_relation'=> 'required',
            'secondary_unit_price'=> 'required',
            'purchase_price'=> 'required',


        ]);
        // dd($request->name);
        Item::create([
            'name' => $request->name,
            'gst' => $request->gst,
            'main_selling_price'=> $request->main_selling_price,
            'secondary_selling_price'=> $request->secondary_unit_price,
        ]);

        $item=Item::where('name',$request->name)->first();

        $batch=new Batch;
        $batch->mrp=$request->mrp;
        $batch->batch_no=$request->batch_no;
        // $batch->HSN=$request->HSN;
        $batch->manufacture_date=$request->manufacture_date;
        $batch->expiry_date=$request->expiry_date;
        $batch->units_main=$request->units_main;
        $batch->main_stock=$request->main_stock;
        $batch->main_selling_price=$request->main_selling_price;
        $batch->units_secondary=$request->units_secondary;
        $batch->units_relation=$request->units_relation;
        $batch->secondary_unit_price=$request->secondary_unit_price;
        $batch->purchase_price=$request->purchase_price;

        $batch->secondary_stock=$request->main_stock*$request->units_relation;

        $item->batches()->save($batch);

        $item->units_main=$request->units_main;
        $item->units_secondary=$request->units_secondary;
        $item->units_relation=$request->units_relation;

        $item->main_stock=$request->main_stock;
        $item->secondary_stock=$request->main_stock*$request->units_relation;
        $item->save();
        // sleep(1);

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
    public function edit($id)
    {
        $item=Item::findOrFail($id);

        $groups= Group::pluck('name','id');

        return Inertia::render('ItemEdit',compact('item','groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        // dd("YEST");
        $item=Item::findOrFail($request->id);
        $request->validate([
            'name' => 'required',

            'gst' => 'required',
          
            
           
        ]);


        $item->name = $request->name;
        $item->gst = $request->gst;
        $item->units_main = $request->units_main;
        $item->units_secondary = $request->units_secondary;
        $item->units_relation = $request->units_relation;
        $item->main_stock = $request->main_stock;
        $item->secondary_stock = $request->secondary_stock;
        $item->main_selling_price = $request->main_selling_price;
        $item->secondary_selling_price = $request->secondary_selling_price;

        $item->save();

        return redirect()->route('items.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item=Item::findOrFail($id);

        $item->delete();

        return redirect()->route('items.index')->with('message', 'Expense Updated Successfully');
    }

    public function search(Request $request)
    {
        // dd($request->search_data);
        $items=Item::where('name','like', '%' .$request->search_data. '%')->orderBy('created_at', 'desc')->paginate(10);

        return Inertia::render('Items',['items' => $items]);

    }

    public function bacthes($id)
    {
        $item=Item::findOrFail($id);
        // dd($item->name);
        $batches = $batches = $item->batches()
        ->latest() // Order by the created_at column in descending order (latest first)
        ->paginate(10);

        $theBatch=$item->batches()->first();

        // dd($theBatch->main_selling_price);

        return Inertia::render('Batch/Index',compact('item','batches','theBatch'));
    }


    public function bacthStore(Request $request)
    {
        //  dd($request->units_main);
         $request->validate([

            'mrp'=> 'required',
            'batch_no'=> 'required',
            // 'HSN'=> 'required',
            'manufacture_date'=> 'required',
            'expiry_date'=> 'required',
            'units_main'=> 'required',
            'main_selling_price'=>'required',
            'main_stock'=>'required',
            'units_secondary'=> 'required',
            'units_relation'=> 'required',
            'secondary_unit_price'=> 'required',
            'purchase_price'=> 'required',


        ]);


        $item=Item::findOrFail($request->item_id);

        $batch=new Batch;
        $batch->mrp=$request->mrp;
        $batch->batch_no=$request->batch_no;
        // $batch->HSN=$request->HSN;
        $batch->manufacture_date=$request->manufacture_date;
        $batch->expiry_date=$request->expiry_date;
        $batch->units_main=$request->units_main;
        $batch->main_stock=$request->main_stock;
        $batch->main_selling_price=$request->main_selling_price;
        $batch->units_secondary=$request->units_secondary;
        $batch->units_relation=$request->units_relation;
        $batch->secondary_unit_price=$request->secondary_unit_price;
        $batch->purchase_price=$request->purchase_price;

        $batch->secondary_stock=$request->main_stock*$request->units_relation;

        // this saves batch
        $item->batches()->save($batch);

        $item->main_stock=$item->main_stock+$request->main_stock;
        $item->secondary_stock=$item->secondary_stock+$request->main_stock*$request->units_relation;
        $item->save();
        // sleep(1);


        $batches = $item->batches()
        ->latest() // Order by the created_at column in descending order (latest first)
        ->paginate(10);

        return Inertia::render('Batch/Index',compact('item','batches'));
    }


    public function batchdestroy($id)
    {
        $batch=Batch::findOrFail($id);
        $item=Item::where('id',$batch->item_id)->first();
        // dd($item->id);


        $batch=Batch::findOrFail($id);

        $item->main_stock=$item->main_stock-$batch->main_stock;
        $item->secondary_stock=$item->secondary_stock-$batch->main_stock*$batch->units_relation;
        $item->save();

        $batch->delete();

        $batches = $item->batches()
        ->latest() // Order by the created_at column in descending order (latest first)
        ->paginate(10);

        return Inertia::render('Batch/Index',compact('item','batches'));
    }
}
