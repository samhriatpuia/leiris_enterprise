<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CustomerController;
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
});


// added

Route::get('/items', [ItemController::class, 'index'])->middleware(['auth', 'verified'])->name('items.index');
Route::get('/items/create', [ItemController::class, 'create'])->middleware(['auth', 'verified'])->name('items.create');
Route::post('/items/store',[ItemController::class, 'store'])->middleware(['auth', 'verified'])->name('items.store');

Route::post('/items/search',[ItemController::class, 'search'])->middleware(['auth', 'verified'])->name('items.search');



Route::get('/groups', [GroupController::class, 'index'])->middleware(['auth', 'verified'])->name('groups.index');
Route::get('/groups/create', [GroupController::class, 'create'])->middleware(['auth', 'verified'])->name('groups.create');
Route::post('/groups/store',[GroupController::class, 'store'])->middleware(['auth', 'verified'])->name('groups.store');


Route::get('/customers',[CustomerController::class, 'index'])->middleware(['auth', 'verified'])->name('customers.index');
Route::get('/customers/create',[CustomerController::class, 'create'])->middleware(['auth', 'verified'])->name('customers.create');
Route::post('/customers/store',[CustomerController::class, 'store'])->middleware(['auth', 'verified'])->name('customers.store');

require __DIR__.'/auth.php';
