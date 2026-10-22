
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\Product;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;


Route::get('/', function () {
    $products = Product::query()
        ->latest()
        ->take(8)
        ->get();

    return view('welcome', compact('products'));
})->name('home');

Route::get('/produk/{product}', function (\App\Models\Product $product) {
    return view('products.show', compact('product'));
})->name('products.show');

/*
|--------------------------------------------------------------------------
| Dashboard utama
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'staff') {
        return redirect()->route('staff.dashboard');
    }

    if ($user->role === 'customer') {
        return redirect()->route('customer.dashboard');
    }

    Auth::logout();

    return redirect()->route('login');
})->middleware(['auth', 'active.account'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Dashboard Admin
|--------------------------------------------------------------------------
*/
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'active.account'])
    ->name('admin.dashboard');
/*
|--------------------------------------------------------------------------
| Manajemen Akun Staff — khusus Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active.account'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])
        ->name('admin.users.index');

    Route::get('/admin/users/create', [UserController::class, 'create'])
        ->name('admin.users.create');

    Route::post('/admin/users', [UserController::class, 'store'])
        ->name('admin.users.store');

    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])
        ->whereNumber('id')
        ->name('admin.users.edit');

    Route::put('/admin/users/{id}', [UserController::class, 'update'])
        ->whereNumber('id')
        ->name('admin.users.update');

    Route::patch('/admin/users/{id}/toggle-active', [
        UserController::class,
        'toggleActive',
    ])->whereNumber('id')->name('admin.users.toggle-active');
});

/*
|--------------------------------------------------------------------------
| Dashboard Staff
|--------------------------------------------------------------------------
*/
Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])
    ->middleware(['auth', 'active.account'])
    ->name('staff.dashboard');
/*
|--------------------------------------------------------------------------
| Dashboard Customer
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Dashboard Customer
|--------------------------------------------------------------------------
*/


Route::middleware(['auth', 'active.account'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/catalog', [CustomerController::class, 'catalog'])->name('catalog');
        Route::get('/products/{id}', [CustomerController::class, 'product'])->whereNumber('id')->name('products.show');
        Route::get('/cart', [CustomerController::class, 'cart'])->name('cart');
        Route::post('/cart/{id}', [CustomerController::class, 'addToCart'])->whereNumber('id')->name('cart.add');
        Route::patch('/cart/{id}', [CustomerController::class, 'updateCart'])->whereNumber('id')->name('cart.update');
        Route::delete('/cart/{id}', [CustomerController::class, 'removeFromCart'])->whereNumber('id')->name('cart.remove');
        Route::get('/checkout', [CustomerController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [CustomerController::class, 'placeOrder'])->name('checkout.store');
        Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [CustomerController::class, 'orderDetail'])->whereNumber('id')->name('order.show');
        Route::get('/transactions', [CustomerController::class, 'transactions'])->name('transactions');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
        Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
    });

/*
|--------------------------------------------------------------------------
| Profile Laravel Breeze
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active.account'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
