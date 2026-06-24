<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RecapController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES (Pintu Masuk)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Langsung arahkan ke route name 'dashboard'
        return redirect()->route('dashboard');
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
})->name('login.process');

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Harus Login Dulu)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // 1. Dashboard
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. Master Data (Category, Supplier, Material)
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('materials', MaterialController::class);

    // 3. Inventory System (Stok & Transaksi)
    Route::resource('stocks', StockController::class);
    Route::resource('transactions', TransactionController::class);

    // 4. Admin Features (Recap & Users)
    Route::get('/recap', [RecapController::class, 'index'])->name('recap.index');
    Route::resource('users', UserController::class);

});
