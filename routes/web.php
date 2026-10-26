
<?php

// controller pengelolaan profil pengguna
use App\Http\Controllers\ProfileController;
// controller akun pengguna 
use App\Http\Controllers\UserController;
//mengambill informasi pengguna login dan autentikasi logout
use Illuminate\Support\Facades\Auth;
// alamat halaman website
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Models\Product;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Staff\ProfileController as StaffProfileController;
use App\Http\Controllers\Staff\CustomerOrderController;
use App\Http\Controllers\Staff\SaleController as StaffSaleController;
use App\Http\Controllers\Staff\PurchaseController as StaffPurchaseController;
use App\Http\Controllers\Admin\ReportController;



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
Route::middleware(['auth', 'active.account'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('purchases', PurchaseController::class)
            ->only(['index', 'show', 'destroy']);

Route::get('/sales', [SaleController::class, 'index'])
    ->name('sales.index');

Route::get('/sales/{sale}', [SaleController::class, 'show'])
    ->name('sales.show');

Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])
    ->name('sales.destroy');

Route::get('/reports', [ReportController::class, 'index'])
    ->name('reports.index');        
    });
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

Route::middleware(['auth', 'active.account'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        // 1. Dashboard
        Route::get('/dashboard', [
            StaffDashboardController::class,
            'index'
        ])->name('dashboard');

        // 2. Produk & Stok
        Route::get('/products', [
            StaffDashboardController::class,
            'products'
        ])->name('products.index');

        // 3. Penjualan langsung
        Route::get('/sales', [
            StaffSaleController::class,
            'index'
        ])->name('sales.index');

        Route::post('/sales', [
            StaffSaleController::class,
            'store'
        ])->name('sales.store');

        // 4. Pembelian / Stock-in
        Route::get('/purchases', [
            StaffPurchaseController::class,
            'index'
        ])->name('purchases.index');

        Route::post('/purchases', [
            StaffPurchaseController::class,
            'store'
        ])->name('purchases.store');

        // 5. Pesanan Customer
        Route::get('/customer-orders', [
            CustomerOrderController::class,
            'index'
        ])->name('customer-orders.index');

        Route::get('/customer-orders/{id}', [
            CustomerOrderController::class,
            'show'
        ])->whereNumber('id')
          ->name('customer-orders.show');

        Route::patch('/customer-orders/{id}', [
            CustomerOrderController::class,
            'update'
        ])->whereNumber('id')
          ->name('customer-orders.update');

        // 6. Riwayat Transaksi
        Route::get('/transactions', [
            StaffDashboardController::class,
            'transactions'
        ])->name('transactions.index');

        // Profil Staff
        Route::get('/profile', [
            StaffProfileController::class,
            'edit'
        ])->name('profile');

        Route::patch('/profile', [
            StaffProfileController::class,
            'update'
        ])->name('profile.update');
    });

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
