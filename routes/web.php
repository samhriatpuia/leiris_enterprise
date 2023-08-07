<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DetailController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
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

    Route::get('/details', [DetailController::class, 'index'])->name('details.index');
    Route::get('/details/create', [DetailController::class, 'create'])->name('details.create');
    Route::post('/details/store',[DetailController::class, 'store'])->name('details.store');

    // added

    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items/store',[ItemController::class, 'store'])->name('items.store');

    Route::post('/items/search',[ItemController::class, 'search'])->name('items.search');



    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups/store',[GroupController::class, 'store'])->name('groups.store');


    Route::get('/customers',[CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create',[CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers/store',[CustomerController::class, 'store'])->name('customers.store');

    Route::get('/settlements/{id}', [SettlementController::class, 'index'])->name('settlements.index');
    Route::post('/settlements/store',[SettlementController::class, 'store'])->name('settlements.store');

});




require __DIR__.'/auth.php';
