<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Item;
use App\Models\Sale;
use App\Models\Detail;
use App\Models\SettlementDetail;
use App\Models\Batch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $next30Days = now()->addDays(30);

        $items = Item::whereHas('batches', function ($query) use ($next30Days) {
            $query->whereDate('expiry_date', '<=', $next30Days);
        })->with(['batches' => function ($query) use ($next30Days) {
            $query->whereDate('expiry_date', '<=', $next30Days);
        }])->paginate(3);


        // Get the current date
        $currentDate = Carbon::now();

        // Get the previous day
        $previousDay = $currentDate->subDay();

        // Format the dates to match the database format (adjust as needed)
        $currentDateString = $currentDate->toDateString();
        $previousDayString = $previousDay->toDateString();

        $cash_in_sales=Sale::where('payment_mode','CASH')->whereDate('date', $previousDayString)->sum('paid');
        $cash_in_settlement=SettlementDetail::where('mode','Cash')->whereDate('created_at', $previousDayString)->sum('amount');
        $total_cash=$cash_in_sales+$cash_in_settlement;

        $upi_in_sales=Sale::where('payment_mode','UPI')->whereDate('date', $previousDayString)->sum('paid');
        $upi_in_settlement=SettlementDetail::where('mode','Upi')->whereDate('created_at', $previousDayString)->sum('amount');
        $total_upi=$upi_in_sales+$upi_in_settlement;


        $cheque_in_sales=Sale::where('payment_mode','CHEQUE')->whereDate('date', $previousDayString)->sum('paid');
        $cheque_in_settlement=SettlementDetail::where('mode','Cheque')->whereDate('created_at', $previousDayString)->sum('amount');
        $total_cheque=$cheque_in_sales+$cheque_in_settlement;

        $netbanking_in_sales=Sale::where('payment_mode','NET BANKING')->whereDate('date', $previousDayString)->sum('paid');
        $netbanking_in_settlement=SettlementDetail::where('mode','Net Banking')->whereDate('created_at', $previousDayString)->sum('amount');
        $total_netbanking=$netbanking_in_sales+$netbanking_in_settlement;


        $allItems=Item::paginate(5);

        $salesDetails = DB::table('details')
        ->select('particulars', DB::raw('SUM(quantity) as total_amount, SUM(amount) as Amount'))
        ->groupBy('particulars')
        ->paginate(5);
        
        return Inertia::render('Dashboard',compact('items','total_cash','total_upi','total_cheque','total_netbanking','allItems','salesDetails'));
    }


    public function payment(Request $request)
    {
        $request->validate([
            'date1' => 'required',
            'date2'=>'required',
        ]);

        $next30Days = now()->addDays(30);

        $items = Item::whereHas('batches', function ($query) use ($next30Days) {
            $query->whereDate('expiry_date', '<=', $next30Days);
        })->with(['batches' => function ($query) use ($next30Days) {
            $query->whereDate('expiry_date', '<=', $next30Days);
        }])->paginate(3);


        // Convert the date strings to Carbon instances
        $startDateTime = Carbon::parse($request->date1)->startOfDay();
        $endDateTime = Carbon::parse($request->date2)->endOfDay();

        $cash_in_sales = Sale::whereBetween('date', [$startDateTime, $endDateTime])->where('payment_mode', 'CASH')->sum('paid');
        $cash_in_settlement=SettlementDetail::whereBetween('created_at', [$startDateTime, $endDateTime])->where('mode', 'Cash')->sum('amount');
        $total_cash=$cash_in_sales+$cash_in_settlement;
        

        $upi_in_sales = Sale::whereBetween('date', [$startDateTime, $endDateTime])->where('payment_mode', 'UPI')->sum('paid');
        $upi_in_settlement=SettlementDetail::whereBetween('created_at', [$startDateTime, $endDateTime])->where('mode', 'Upi')->sum('amount');
        $total_upi=$upi_in_sales+$upi_in_settlement;

        $cheque_in_sales = Sale::whereBetween('date', [$startDateTime, $endDateTime])->where('payment_mode', 'CHEQUE')->sum('paid');
        $cheque_in_settlement=SettlementDetail::whereBetween('created_at', [$startDateTime, $endDateTime])->where('mode', 'Cheque')->sum('amount');
        $total_cheque=$cheque_in_sales+$cheque_in_settlement;

        $netbanking_in_sales = Sale::whereBetween('date', [$startDateTime, $endDateTime])->where('payment_mode', 'NET BANKING')->sum('paid');
        $netbanking_in_settlement=SettlementDetail::whereBetween('created_at', [$startDateTime, $endDateTime])->where('mode', 'Net Banking')->sum('amount');
        $total_netbanking=$netbanking_in_sales+$netbanking_in_settlement;


        $allItems=Item::paginate(5);

        return Inertia::render('Dashboard',compact('items','total_cash','total_upi','total_cheque','total_netbanking','allItems'));

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'desc')->paginate(10);
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
            'address' => 'required',
            'phone' => 'required',
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
            // 'gst' => 'required',
            'address' => 'required',
            'phone' => 'required',
            // 'bank_account' => 'required',
            // 'bank_ifsc' => 'required',
            // 'bank_name' => 'required',
            // 'bank_branch' => 'required',

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
