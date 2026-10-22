
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\Product;

Route::get('/', function () {
    $products = Product::query()
        ->latest()
        ->take(8)
        ->get();

    return view('welcome', compact('products'));
})->name('home');

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
Route::get('/staff/dashboard', function () {
    abort_unless(Auth::user()->role === 'staff', 403);

    return view('dashboard');
})->middleware(['auth', 'active.account'])->name('staff.dashboard');

/*
|--------------------------------------------------------------------------
| Dashboard Customer
|--------------------------------------------------------------------------
*/
Route::get('/customer/dashboard', function () {
    abort_unless(Auth::user()->role === 'customer', 403);

    return view('customer.dashboard');
})->middleware(['auth', 'active.account'])->name('customer.dashboard');

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
