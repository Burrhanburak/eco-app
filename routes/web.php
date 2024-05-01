<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('frontend.index');
//});

Route::get('/', [HomesController::class, 'index'])->name('frontend.index');


Route::get('/dashboard', [UserController::class, 'UserDashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/edit', [UserController::class, 'edit'])->middleware(['auth', 'verified'])->name('dashboard.edit');
Route::patch('/dashboard/update', [UserController::class, 'update'])->middleware(['auth', 'verified'])->name('dashboard.update');
Route::delete('/dashboard/destroy', [UserController::class, 'destroy'])->middleware(['auth', 'verified'])->name('dashboard.destroy');

//Route::middleware(['auth', 'verified'])->group(function () {
//
//    Route::get('/dashboard', [UserController::class, 'edit'])->name('dashboard.edit');
//    Route::patch('/dashboard', [UserController::class, 'update'])->name('dashboard.update');
//    Route::delete('/dashboard', [UserController::class, 'destroy'])->name('dashboard.destroy');
//});


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get("/basket", [CartController::class, 'index']);
    Route::get("/basket/add/{product}", [CartController::class, 'add']);
//    Route::get("/basket/delete/{cartDetail}", [CartController::class, 'remove']);
    Route::get('/basket/delete/{cartDetail}', [CartController::class, 'remove'])->name('basket.delete');
     Route::get('/orders', [CartController::class, 'orders'])->name('orders');

    Route::get("/payment", [CheckoutController::class, 'showCheckoutForm']);
    Route::post("/payment", [CheckoutController::class, 'checkout']);
//    Route::get('/checkout/error', function () {
//        return view('frontend.checkout.error');
//    })->name('frontend.checkout.error');
//
//    Route::get('/checkout/success', function () {
//        return view('frontend.checkout.success');
//    })->name('frontend.checkout.success');
//
//    Route::post('/checkout/threeds/callback', [CheckoutController::class, 'iyzicoCallback'])
//        ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class)->name('checkout.threeds.callback');

    Route::post('/checkout/threeds/callback', [CheckoutController::class, 'iyzicoCallback'])->name('checkout.threeds.callback');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

\Illuminate\Support\Facades\Auth::routes();

Route::get('/home', [App\Http\Controllers\HomesController::class, 'index'])->name('home');
