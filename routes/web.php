<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController; // Tambahkan controller laporan
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\RedirectIfAuthenticatedByRole;
use App\Http\Middleware\PreventBackHistory;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => Response::nocache(view('beranda')));

/*
|--------------------------------------------------------------------------
| Auth: Login & Register (Guest Only)
|--------------------------------------------------------------------------
*/
Route::middleware([RedirectIfAuthenticatedByRole::class])->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
});

/*
|--------------------------------------------------------------------------
| Prevent Back After Logout
|--------------------------------------------------------------------------
*/
Route::middleware([PreventBackHistory::class])->group(function () {
    Route::get('/', fn () => view('beranda'));
});

/*
|--------------------------------------------------------------------------
| Dashboard Role Based
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', CheckRole::class . ':pelanggan'])->group(function () {
    Route::get('/pelanggan/dashboard', function () {
        $orders = \App\Models\Order::where('user_id', auth()->id())
            ->where('status', '!=', 'pending')
            ->whereDate('tanggal', '>=', \Carbon\Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->count();

        return view('pelanggan.dashboard', compact('orders'));
    })->name('pelanggan.dashboard');

    Route::get('/pelanggan/akun', [ProfileController::class, 'edit'])->name('pelanggan.akun');
});

Route::middleware(['auth', CheckRole::class . ':pemilik'])->group(function () {
    Route::get('/pemilik/dashboard', function () {
        $pendingCount = \App\Models\Order::where('status', 'pending')->count();
        return view('pemilik.dashboard', compact('pendingCount'));
    })->name('pemilik.dashboard');

    // Tambahkan route laporan
    Route::get('/pemilik/laporan', [OrderController::class, 'laporan'])->name('pemilik.laporan.index');
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/akun', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/akun', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/akun', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Modul Lapangan & Pemesanan
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::resource('fields', FieldController::class);

    Route::get('pemilik/lapangan/{lapanganId}/detail/{tanggal}', [FieldController::class, 'detailLapangan'])->name('pemilik.lapangan.detail');

    // Pelanggan
    Route::get('pelanggan/pesan', [OrderController::class, 'index'])->name('pelanggan.fields.index');
    Route::get('pelanggan/pesan/create', [OrderController::class, 'create']);
    Route::post('pelanggan/pesan/store', [OrderController::class, 'store']);
    Route::patch('pelanggan/pesan/batal/{id}', [OrderController::class, 'cancelOrder'])->name('pelanggan.order.cancel');
    Route::get('pelanggan/pesan/data', [OrderController::class, 'data_order'])->name('pelanggan.fields.data');

    // Pemilik
    Route::get('pemilik/pesan/data', [OrderController::class, 'owner_data_order'])->name('pemilik.orders.data');
    Route::put('pemilik/pesan/data/{order_unique_id}', [OrderController::class, 'updateStatus'])->name('pemilik.orders.updateStatus');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (logout, dll)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
