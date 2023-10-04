<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Inertia\Inertia;
use App\Models\Sale;
use App\Models\Sale2;
use App\Models\Customer;
use App\Models\Detail;
use App\Models\Settlement;
use App\Models\Detail2;
use App\Models\Item;
use App\Models\Batch;
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
        // dd($request->new_name);
        // dd($request->invoice_number);
        $request->validate([
            'date' => 'required',
            'invoice_number' => 'required',
            'customer_id' => 'required_without:new_name',
            'new_name' => 'required_without:customer_id',


        ]);

        if (is_null($request->new_name))
        {
            $customer=Customer::findOrFail($request->customer_id);
            // dd($customer->id);
            Sale::create([
                'customer_id' => $request->customer_id,
                'date' => $request->date,
                'invoice_number' => $request->invoice_number,

                'customer_name' => $customer->name,

            ]);

            $sale=Sale::where('customer_id',$request->customer_id)->where('invoice_number',$request->invoice_number)->first();

            // dd($sale->invoice_number);

            return redirect()->route('sales.invoice.index',$sale->id)->with('message', 'Sales Created Successfully');

        }
        else
        {
            // dd($request->new_name);
            Customer::create([
                'name' => $request->new_name,
                'phone'=>$request->phone,
                'address'=>$request->address,
                'gst'=>$request->gst,
            ]);
            $customer=Customer::where('name',$request->new_name)->latest()->first();

            Sale::create([
                'customer_id' => $customer->id,
                'date' => $request->date,
                'invoice_number' => $request->invoice_number,
                'customer_name' => $customer->name,
            ]);

            $sale=Sale::where('customer_id',$customer->id)->latest()->first();



            return redirect()->route('sales.invoice.index',$customer->id)->with('message', 'Sales Created Successfully');

        }

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
        $sale2=Sale2::findOrFail($request->id);
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


        $sale2->customer_id = $request->customer_id;
        $sale2->date = $request->date;
        $sale2->invoice_number = $request->invoice_number;
        $sale2->logistic_charge = $request->logistic_charge;
        $sale2->handling_charge = $request->handling_charge;
        $sale2->discount = $request->discount;
        $sale2->scheme = $request->scheme;

        $sale2->customer_name = $customer->name;

        $sale2->save();




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
        $batches=Batch::pluck('batch_no','id');
        $customer=Customer::where('id',$sale->customer_id)->first();
        // dd($customer->id);
        $details=Detail::where('sales_id',$sale->id)->paginate(10);
        $items=Item::pluck('name','id');
        return Inertia::render('Sales/Invoice',compact('customer','sale','details','items','batches'));
    }


    public function invoiceStore(Request $request)
    {
        // dd($request->batch_no);
        $request->validate([
            // 'particulars' => 'required',
            'quantity'=>'required',
            'unit'=>'required',
            // 'price'=>'required'

        ]);

        if(is_null($request->new_name))
        {
            $item=Item::where('id',$request->particulars)->first();
           
            $batch=Batch::where('item_id', $item->id)->where('batch_no', $request->batch_no)->first();

            if($request->unit=='primary')
            {
                $thePrice=$item->main_selling_price;
                $theUnit=$item->units_main;
                $mainStock=(int)$item->main_stock-(int)$request->quantity;
                $item->main_stock=$mainStock;

                $item->secondary_stock=$mainStock*(int)$item->units_relation;
                $item->save();

                $theMainStck=(int)$batch->main_stock-(int)$request->quantity;
                
                $batch->secondary_stock=$theMainStck*(int)$batch->units_relation;
                $batch->main_stock=$theMainStck;
                $batch->save();

            }
            else
            {
                $thePrice=$item->secondary_selling_price;
                $theUnit=$item->units_secondary;

                $newValueOfSecondaryStock=(int)$item->secondary_stock-(int)$request->quantity;


                $newValueOfPrimaryStock=(float)($newValueOfSecondaryStock)/(float)($item->units_relation);

                $item->main_stock=$newValueOfPrimaryStock;
                $item->secondary_stock=$newValueOfSecondaryStock;

                $item->save();

                $theSecStk=(int)$batch->secondary_stock-(int)$request->quantity;
                $batch->secondary_stock=$theSecStk;
                $batch->main_stock=(float)$theSecStk/(float)($batch->units_relation);
                $batch->save();

            }


            Detail::create([
                'particulars' => $item->name,
                'quantity' => $request->quantity,
                'unit'=>$theUnit,
                'price'=>$thePrice,
                'discount'=>$request->discount,
                'amount'=>($thePrice*$request->quantity)-($request->discount),
                'sales_id'=>$request->sales_id,
                'batch'=>$request->batch_no,
            ]);

           

            $sale=Sale::where('id',$request->sales_id)->first();
            $sale2=Sale2::where('id',$request->sales_id)->first();
            $details1=Detail::where('sales_id',$sale->id)->get();

            $sale->sub_total=0;

            foreach($details1 as $detail)
            {
                $sale->sub_total=$sale->sub_total+$detail->amount;
            }


            $sale->save();

            $customer=Customer::where('id',$sale->customer_id)->first();

            $details=Detail::where('sales_id',$sale->id)->paginate(10);
            $items=Item::pluck('name','id');
            return Inertia::render('Sales/Invoice',compact('customer','sale','details','items'));
        }
        else
        {
            $newitem=new Item();
            $newitem->name=$request->new_name;
            // $newitem->batch_no=$request->batch;
            $newitem->main_stock =$request->stock_opening ;
            $newitem->main_selling_price =$request->selling_price ;
            $newitem->units_secondary =$request->units_secondary ;
            $newitem->units_main =$request->units_main ;
            $newitem->units_relation =$request->units_relation ;
            $newitem->secondary_selling_price =$request->secondary_unit_price ;
            $newitem->secondary_stock=(int)$request->stock_opening*(int)$request->units_relation;
            $newitem->save();

            $theitem=Item::where('name',$request->new_name)->first();
            // Create new batch
            $newBatch=new Batch();
            $newBatch->item_id=$theitem->id;
            $newBatch->units_main=$request->units_main;
            $newBatch->main_stock=$request->stock_opening;
            $newBatch->main_selling_price=$request->selling_price;
            $newBatch->units_secondary=$request->units_secondary;
            $newBatch->units_relation=$request->units_relation;
            $newBatch->secondary_stock=(int)$request->stock_opening*(int)$request->units_relation;
            $newBatch->secondary_unit_price=$request->secondary_unit_price;
            $newBatch->batch_no=$request->batch_no;

            $newBatch->save();

            $batch=Batch::where('item_id',$theitem->id)->where('batch_no', $request->batch_no)->first();
            // dd($item->name);
            if($request->unit=='primary')
            {
                $thePrice=$theitem->main_selling_price;
                $theUnit=$theitem->units_main;
                // $theitem->stock_opening=(int)$theitem->stock_opening-(int)$request->quantity;
                // $theitem->main_stock=((int)$theitem->main_stock)-((int)$request->quantity);

                $mainStock=(int)$theitem->main_stock-(int)$request->quantity;
                $theitem->main_stock=$mainStock;

                $theitem->secondary_stock=$mainStock*(int)$theitem->units_relation;

                $theitem->save();

                $theMainStck=(int)$batch->main_stock-(int)$request->quantity;
                
                $batch->secondary_stock=$theMainStck*(int)$batch->units_relation;
                $batch->main_stock=$theMainStck;
                $batch->save();

                // dd($theUnit);
            }
            else
            {
                // $thePrice=$item->secondary_unit_price;
                // $theUnit=$item->units_secondary;

                $thePrice=$theitem->secondary_selling_price;
                $theUnit=$theitem->units_secondary;

                $newValueOfSecondaryStock=(int)($theitem->secondary_stock)-((int)$request->quantity);

                $newValueOfPrimaryStock=(float)$newValueOfSecondaryStock/((float)$theitem->units_relation);

                $theitem->save();


                $theSecStk=(int)$batch->secondary_stock-(int)$request->quantity;
                $batch->secondary_stock=$theSecStk;
                $batch->main_stock=(float)$theSecStk/(float)($batch->units_relation);
                $batch->save();

            }

            // dd($request->sales_id);
            Detail::create([
                'particulars' => $theitem->name,
                'quantity' => $request->quantity,
                'unit'=>$theUnit,
                'price'=>$thePrice,
                'discount'=>$request->discount,
                'amount'=>($thePrice*$request->quantity)-($request->discount),
                'sales_id'=>$request->sales_id,
                'batch'=>$request->batch_no,
            ]);

            $sale=Sale::where('id',$request->sales_id)->first();
            $sale2=Sale2::where('id',$request->sales_id)->first();
            $details1=Detail::where('sales_id',$sale->id)->get();

            $sale->sub_total=0;

            foreach($details1 as $detail)
            {
                $sale->sub_total=$sale->sub_total+$detail->amount;
            }


            $sale->save();

            $customer=Customer::where('id',$sale->customer_id)->first();

            $batches=Batch::pluck('batch_no','id');

            $details=Detail::where('sales_id',$sale->id)->paginate(10);
            $items=Item::pluck('name','id');
            return Inertia::render('Sales/Invoice',compact('customer','sale','details','items','batches'));
        }

    }

// Generate word
    public function invoice_generate($id)
    {

        $sale=Sale::findOrFail($id);
        $details=Detail::where('sales_id',$sale->id)->get();
       
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $invoice_number= htmlspecialchars($sale->invoice_number);
        $date=htmlspecialchars($sale->date);
        $logistic_charge=htmlspecialchars($sale->logistic_charge);
        $handling_charge=htmlspecialchars($sale->handling_charge);
        $discount=htmlspecialchars($sale->discount);
        $scheme=htmlspecialchars($sale->scheme);
        $sub_total=htmlspecialchars($sale->sub_total);
        $grand_total=htmlspecialchars($sale->grand_total);
        $Paid=htmlspecialchars($sale->paid);
        $currentBalance=htmlspecialchars($sale->current_balance);

        $customer=Customer::where('id',$sale->customer_id)->first();
        $customer_name=htmlspecialchars($customer->name);
        $gst=htmlspecialchars($customer->gst);
        $phone=htmlspecialchars($customer->phone);
        $address=htmlspecialchars($customer->address);

        $section = $phpWord->addSection();
        $phpWord->setDefaultFontSize(13);


        $text1 = 'Leiris Enterprise';
        $alignment = \PhpOffice\PhpWord\SimpleType\Jc::CENTER; // Set the alignment to center
        $section->addText($text1, null, array('alignment' => $alignment));

      
        $text2 = 'GST No.: AXPPL5682';
        $alignment = \PhpOffice\PhpWord\SimpleType\Jc::CENTER; // Set the alignment to center
        $section->addText($text2, null, array('alignment' => $alignment));


       
        $section->addTextBreak(2);

      
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(6000)->addText('Customer Details<w:br/>Name: '.$customer_name.'<w:br/>Phone: '.$phone.'<w:br/>Address: '.$address.'<w:br/>GST: '.$gst);
        $table->addCell(2000)->addText('');
        $table->addCell(6000)->addText('Invoice No: '.$invoice_number.'<w:br/>Date: '.$date);





        $section->addTextBreak(2);

        $table = $section->addTable();
        $table->addRow();
        $table->addCell(2000)->addText('Particular');
        $table->addCell(1000)->addText('Quantity');
        $table->addCell(1000)->addText('Discount');
        $table->addCell(1000)->addText('Price');
        $table->addCell(1000)->addText('Amount');

       
        foreach ($details as $detail) {
            $table->addRow();
            $table->addCell(3000)->addText($detail->particulars);
            $table->addCell(2000)->addText($detail->quantity);
            $table->addCell(2000)->addText($detail->discount);
            $table->addCell(2000)->addText($detail->price);
            $table->addCell(2000)->addText($detail->amount);
        }

        $section->addTextBreak(2); 





        $text3 = 'Sub Total: '.$sub_total;
        $alignment = \PhpOffice\PhpWord\SimpleType\Jc::RIGHT; 
        $section->addText($text3, null, array('alignment' => $alignment));

        $text5 = 'Logistics: '.$logistic_charge;
        $alignment = \PhpOffice\PhpWord\SimpleType\Jc::RIGHT; 
        $section->addText($text5, null, array('alignment' => $alignment));

        $text6 = 'Handling: '.$handling_charge;
        $alignment = \PhpOffice\PhpWord\SimpleType\Jc::RIGHT; 
        $section->addText($text6, null, array('alignment' => $alignment));


        $text4 = 'Grand Total: '.$grand_total;
        $alignment = \PhpOffice\PhpWord\SimpleType\Jc::RIGHT; 
        $section->addText($text4, null, array('alignment' => $alignment));

        $text7 = 'Cash Tendered: '.$Paid;
        $alignment = \PhpOffice\PhpWord\SimpleType\Jc::RIGHT;
        $section->addText($text7, null, array('alignment' => $alignment));


        $text8 = 'Current Balance: '.$currentBalance;
        $alignment = \PhpOffice\PhpWord\SimpleType\Jc::RIGHT; 
        $section->addText($text8, null, array('alignment' => $alignment));


       
        foreach ($table->getRows() as $row) {
            foreach ($row->getCells() as $cell) {
                $cellStyle = $cell->getStyle();
                $cellStyle->setBorderTopSize(1);
                $cellStyle->setBorderTopColor('010101');
                $cellStyle->setBorderBottomSize(1);
                $cellStyle->setBorderBottomColor('000000');
            }
        }

     


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
                $objWriter->save(storage_path($date.'.doc'));
            } catch (Exception $e) {
        }


        return response()->download(storage_path($date.'.doc'))->deleteFileAfterSend(true);
    }



    public function destroyDetails($id)
    {
        $detail=Detail::findOrFail($id);

        // dd($detail->quantity);
        $item=Item::where('name',$detail->particulars)->first();
        // dd($item);
        $sale=Sale::where('id',$detail->sales_id)->first();
        
        $batch=Batch::where('item_id', $item->id)->where('batch_no', $detail->batch)->first();
        // dd($batch);

        if($detail->unit == "BAG" || $detail->unit == "CASE"|| $detail->unit == "PIECE"|| $detail->unit == "TIN"|| $detail->unit == "PACKET")
        {
            $valueOfMainStock=(int)$item->main_stock+$detail->quantity;
            $item->main_stock=$valueOfMainStock;
            $valueOfSecondaryStock=$valueOfMainStock*(int)$item->units_relation;
            $item->secondary_stock=$valueOfSecondaryStock;
            $item->save();

            $mainStock=(int)$batch->main_stock+(int)$detail->quantity;
            $batch->main_stock=$mainStock;
            $batch->secondary_stock=$mainStock*(int)($batch->units_relation);
            $batch->save();
        }
        else
        {
            $cal=(int)$item->secondary_stock+(int)$detail->quantity;
            $item->secondary_stock=$cal;
            $item->main_stock=(float)$cal/(float)$item->units_relation;
            $item->save();


            $theSecStk=(int)$batch->secondary_stock+(int)$detail->quantity;
            $batch->secondary_stock=$theSecStk;
            $batch->main_stock=(float)$theSecStk/(float)($batch->units_relation);
            $batch->save();
        }

        $sale->sub_total=$sale->sub_total-$detail->amount;


        $detail->delete();

        $sale->save();

        $batches=Batch::pluck('batch_no','id');

        $customer=Customer::where('id',$sale->customer_id)->first();

        $details=Detail::where('sales_id',$sale->id)->paginate(10);
        $items=Item::pluck('name','id');
        return Inertia::render('Sales/Invoice',compact('customer','sale','details','items','batches'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'logistic_charge' => 'required',
            'handling_charge' => 'required',
            'id' => 'required_without:new_name',
            'discount' => 'required_without:customer_id',

        ]);

        $sale=Sale::findOrFail($request->id);
        $grand_total=$sale->sub_total+$request->logistic_charge+$request->handling_charge-($request->discount);

        $currentBalance=$grand_total-$request->paid;

        $sale->current_balance=$currentBalance;
        $sale->grand_total=$grand_total;
        $sale->paid=$request->paid;
        $sale->logistic_charge=$request->logistic_charge;
        $sale->handling_charge=$request->handling_charge;
        $sale->discount=$request->discount;
        $sale->save();

        if (Settlement::where('customer_id', $sale->customer_id)->exists()) {

            $theSettlement=Settlement::where('customer_id',$sale->customer_id)->first();

            $sales=Sale::where('customer_id',$sale->customer_id)->get();
            $gt=0;//grand total
            foreach($sales as $sale)
            {
                $gt=$gt+$sale->current_balance;
            }
            $theSettlement->grand_total=$gt;
            $theSettlement->save();
        }else{
            Settlement::create([
                'grand_total' => $sale->current_balance,
                'customer_id' => $sale->customer_id,
            ]);
        }



        $customer=Customer::where('id',$sale->customer_id)->first();

        $details=Detail::where('sales_id',$sale->id)->paginate(10);
        $items=Item::pluck('name','id');
        return Inertia::render('Sales/Invoice',compact('customer','sale','details','items'));
    }
}
