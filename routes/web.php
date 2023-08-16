<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\Sale2Controller;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SettlementController;
use Illuminate\Foundation\Application;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/', function () {
    return Inertia::render('Auth/Login');
});



Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales/store',[SaleController::class, 'store'])->name('sales.store');
    Route::post('/sales/search',[SaleController::class, 'search'])->name('sales.search');
    Route::get('sales/invoice/index/{id}',[SaleController::class, 'invoiceIndex'])->name('sales.invoice.index');
    Route::post('sales/invoice/store',[SaleController::class, 'invoiceStore'])->name('sales.invoice.store');
    Route::get('sales/invoice/edit/{id}',[SaleController::class, 'edit'])->name('sales.invoice.edit');
    Route::put('/sales/update', [SaleController::class, 'update'])->name('sales.update');
    Route::get('/invoice_generate/{id}',[SaleController::class,'invoice_generate'])->name('invoice_generate');


    // History of sales
    Route::get('/history', [Sale2Controller::class, 'index'])->name('history.index');
    Route::post('/history/search',[Sale2Controller::class, 'search'])->name('history.search');
    Route::get('history/invoice/index/{id}',[Sale2Controller::class, 'invoiceIndex'])->name('history.invoice.index');

    Route::get('/details', [DetailController::class, 'index'])->name('details.index');
    Route::get('/details/create', [DetailController::class, 'create'])->name('details.create');
    Route::post('/details/store',[DetailController::class, 'store'])->name('details.store');
    Route::delete('/details/delete/{id}', [SaleController::class, 'destroyDetails'])->name('details.destroy');
    // added

    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items/store',[ItemController::class, 'store'])->name('items.store');

    Route::post('/items/search',[ItemController::class, 'search'])->name('items.search');
    Route::delete('/items/delete/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::get('/items/edit/{id}', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/update', [ItemController::class, 'update'])->name('items.update');

    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups/store',[GroupController::class, 'store'])->name('groups.store');
    Route::post('/groups/search',[GroupController::class, 'search'])->name('groups.search');
    Route::delete('/groups/delete/{id}', [GroupController::class, 'destroy'])->name('groups.destroy');
    Route::get('/groups/edit/{id}', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/update', [GroupController::class, 'update'])->name('groups.update');


    Route::get('/customers',[CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create',[CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers/store',[CustomerController::class, 'store'])->name('customers.store');
    Route::post('/customers/search',[CustomerController::class, 'search'])->name('customers.search');
    Route::delete('/customers/delete/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/edit/{id}', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/update', [CustomerController::class, 'update'])->name('customers.update');


    Route::get('/settlements/{id}', [SettlementController::class, 'index'])->name('settlements.index');
    Route::post('/settlements/store',[SettlementController::class, 'store'])->name('settlements.store');
    Route::delete('/settlements/delete/{id}',[SettlementController::class,'destroy'])->name('settlements.destroy');

    
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/purchases/store',[PurchaseController::class, 'store'])->name('purchases.store');
    Route::post('/purchases/search',[PurchaseController::class, 'search'])->name('purchases.search');
    Route::get('purchases/invoice/index/{id}',[PurchaseController::class, 'invoiceIndex'])->name('purchases.invoice.index');
    Route::post('purchases/invoice/store',[PurchaseController::class, 'invoiceStore'])->name('purchases.invoice.store');
    Route::get('purchases/edit/{id}',[PurchaseController::class, 'edit'])->name('purchases.edit');
    Route::put('/purchases/update/{id}', [PurchaseController::class, 'update'])->name('purchases.update');
    Route::delete('/purchases/delete/{id}',[PurchaseController::class,'destroy'])->name('purchases.destroy');
    Route::delete('/purchaseDetails/delete/{id}',[PurchaseController::class,'destroyPurchaseDetails'])->name('purchaseDetails.destroy');

});




require __DIR__.'/auth.php';
