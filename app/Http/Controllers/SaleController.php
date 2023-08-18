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
        ]);
        Sale2::create([
            'customer_id' => $request->customer_id,
            'date' => $request->date,
            'invoice_number' => $request->invoice_number,
            'logistic_charge' => $request->logistic_charge,
            'handling_charge' => $request->handling_charge,
            'discount' => $request->discount,
            'scheme' => $request->scheme,

            'customer_name' => $customer->name,
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
            'discount'=>$request->discount,
            'amount'=>($item->selling_price*$request->quantity)-($request->discount),
            'sales_id'=>$request->sales_id,
        ]);



        Detail2::create([
            'particulars' => $item->name,
            'quantity' => $request->quantity,
            'unit'=>$item->units_main,
            'price'=>$item->selling_price,
            'discount'=>$request->discount,
            'amount'=>($item->selling_price*$request->quantity)-($request->discount),
            'sales_id'=>$request->sales_id,
        ]);


        $sale=Sale::where('id',$request->sales_id)->first();
        $sale2=Sale2::where('id',$request->sales_id)->first();
        // dd($request->sales_id);
        $details1=Detail::where('sales_id',$sale->id)->get();
        $details2=Detail2::where('sales_id',$sale->id)->get();

        $sale->sub_total=0;

        foreach($details1 as $detail)
        {
            $sale->sub_total=$sale->sub_total+$detail->amount;
        }

        

        $sale->grand_total=$sale->sub_total+$sale->logistic_charge+$sale->handling_charge-$sale->discount;
        
        $sale2->grand_total=$sale->grand_total;
        $sale2->sub_total=$sale->sub_total;
       
        $sale->save();
        $sale2->save();



        // dd($sale->sub_total);
        $customer=Customer::where('id',$sale->customer_id)->first();

        if (Settlement::where('customer_id', $customer->id)->exists()) {
           
            $theSettlement=Settlement::where('customer_id',$customer->id)->first();
            // dd($theSettlement->grand_total);
            $theSettlement->grand_total=$theSettlement->grand_total+(($item->selling_price*$request->quantity)-($request->discount));
            $theSettlement->save();
        }else{
            Settlement::create([
                'grand_total' => $sale->grand_total,
                'customer_id' => $customer->id,
            ]);
        }

        $details=Detail::where('sales_id',$sale->id)->paginate(10);
        $items=Item::pluck('name','id');
        return Inertia::render('Sales/Invoice',compact('customer','sale','details','items'));
    }


    public function invoice_generate($id)
    {
        
        $sale=Sale::findOrFail($id);
        $details=detail::where('sales_id',$sale->id)->get();
        // $dept=Department::where('id',$deposit->department_id)->first();
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $invoice_number= htmlspecialchars($sale->invoice_number);
        $date=htmlspecialchars($sale->date);
        $address=htmlspecialchars($sale->address);
        $contact=htmlspecialchars($sale->_no);
        $section = $phpWord->addSection();
        $phpWord->setDefaultFontSize(13);
        $customer=htmlspecialchars($sale->customer);
        $payment=htmlspecialchars($sale->payment_mode);
        $total=htmlspecialchars($sale->total);
        // Create a new section


        // Add the heading
        
        $text1 = 'CCR Enterprise';
        $alignment = \PhpOffice\PhpWord\SimpleType\Jc::CENTER; // Set the alignment to center
        $section->addText($text1, null, array('alignment' => $alignment));
        
        // Add text to the section with centered alignment
        $text2 = 'GST No.: AXPPL5682';
        $alignment = \PhpOffice\PhpWord\SimpleType\Jc::CENTER; // Set the alignment to center
        $section->addText($text2, null, array('alignment' => $alignment));


        // Add empty paragraph for spacing
        $section->addTextBreak(2); // Add 2 line breaks for more spacing

        // Add invoice details
        $section->addText('Invoice Number: ' . $invoice_no);
        $section->addText('Date: ' . $date);
        $section->addText('Customer: ' . $customer);
        $section->addText('Address: ' . $address);
        $section->addText('Payment: ' . $payment);

        

        $section->addTextBreak(2);
// Create a table for the sales list
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(2000)->addText('Particular');
        $table->addCell(1000)->addText('Quantity');
        $table->addCell(1000)->addText('Rate');
        $table->addCell(1000)->addText('Discount');
        $table->addCell(1000)->addText('Amount');

        // Set border style for each cell in the table
        

        // Populate the table with sales data
        foreach ($details as $detail) {
            $table->addRow();
            $table->addCell(2000)->addText($detail->particulars);
            $table->addCell(1000)->addText($detail->quantity);
            $table->addCell(2000)->addText($detail->rate);
            $table->addCell(2000)->addText($detail->discount.'%');
            $table->addCell(2000)->addText($detail->amount);
        }

        

        // Calculate and display subtotal, taxes, and total
        // $subtotal = array_sum(array_column($salesList, 3));
        // $taxes = $subtotal * 0.1; // Assuming 10% tax rate
        // $total = $subtotal + $taxes;

        // $table->addRow();
        // $table->addCell(3000)->addText('');
        // $table->addCell(2000)->addText('');
        // $table->addCell(2000)->addText('Subtotal:');
        // $table->addCell(2000)->addText('$' . $subtotal);

        // $table->addRow();
        // $table->addCell(3000)->addText('');
        // $table->addCell(2000)->addText('');
        // $table->addCell(2000)->addText('Taxes:');
        // $table->addCell(2000)->addText('$' . $taxes);

        
        // $table->addRow();
        // $table->addCell(3000)->addText('');
        // $table->addCell(3000)->addText('');
        // $table->addCell(2000)->addText('');
        // $table->addCell(2000)->addText('Total:');
        // $table->addCell(2000)->addText('$' . $total);

        $section->addTextBreak(2); // Add 2 line breaks for more spacing
       
        $text3 = 'TOTAL:  '.$total;
        $alignment = \PhpOffice\PhpWord\SimpleType\Jc::CENTER; // Set the alignment to center
        $section->addText($text3, null, array('alignment' => $alignment));

        // Set border style for each cell in the table
        foreach ($table->getRows() as $row) {
            foreach ($row->getCells() as $cell) {
                $cellStyle = $cell->getStyle();
                $cellStyle->setBorderTopSize(1);
                $cellStyle->setBorderTopColor('000000');
                $cellStyle->setBorderBottomSize(1);
                $cellStyle->setBorderBottomColor('000000');
            }
        }
       
        // $section->addText($description);


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

        $sale=Sale::where('id',$detail->sales_id)->first();
        
        // $details1=Detail::where('sales_id',$sale->id)->get();

        $sale->sub_total=$sale->sub_total-$detail->amount;

        $sale->grand_total=$sale->grand_total-$detail->amount;

        $theSettlement=Settlement::where('customer_id',$sale->customer_id)->first();

        $theSettlement->grand_total=$theSettlement->grand_total-$detail->amount;
        $theSettlement->save();
        $detail->delete();
       
        $sale->save();
        


        
        // dd($sale->id);
        $customer=Customer::where('id',$sale->customer_id)->first();
        // dd($customer->id);
        $details=Detail::where('sales_id',$sale->id)->paginate(10);
        $items=Item::pluck('name','id');
        return Inertia::render('Sales/Invoice',compact('customer','sale','details','items'));
    }
}
