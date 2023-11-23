<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

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


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get("/basket", [CartController::class, 'index']);
    Route::get("/basket/add/{product}", [CartController::class, 'add']);
//    Route::get("/basket/delete/{cartDetail}", [CartController::class, 'remove']);
    Route::get('/basket/delete/{cartDetail}', [CartController::class, 'remove'])->name('basket.delete');

    Route::get("/payment", [CheckoutController::class, 'showCheckoutForm']);
    Route::post("/payment", [CheckoutController::class, 'checkout']);
    Route::post('/checkout/threeds-callback',[CheckoutController::class, 'iyzicoCallback'])->name('checkout.threeds.callback');
});
//Route::match(array('GET','POST'),'/callback/{user}', [CheckoutController::class, 'callback'])
//    ->name('callback')
//    ->middleware('signed');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

\Illuminate\Support\Facades\Auth::routes();

Route::get('/home', [App\Http\Controllers\HomesController::class, 'index'])->name('home');
