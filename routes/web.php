
<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard utama: arahkan pengguna sesuai role
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
})->middleware('auth')->name('dashboard');

// Dashboard Admin
Route::get('/admin/dashboard', function () {
    abort_unless(Auth::user()->role === 'admin', 403);

    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');

Route::get('/admin/users', [UserController::class, 'index'])
    ->middleware('auth')
    ->name('admin.users.index');

// Dashboard Staff
Route::get('/staff/dashboard', function () {
    abort_unless(Auth::user()->role === 'staff', 403);

    return view('staff.dashboard');
})->middleware('auth')->name('staff.dashboard');

// Dashboard Customer
Route::get('/customer/dashboard', function () {
    abort_unless(Auth::user()->role === 'customer', 403);

    return view('customer.dashboard');
})->middleware('auth')->name('customer.dashboard');

// Profile bawaan Laravel Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');
});

require __DIR__.'/auth.php';
