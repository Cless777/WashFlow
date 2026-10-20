<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ContactMessageController;


// ═══════════════════════════════════════════════════════════════════════════
// PUBLIC
// ═══════════════════════════════════════════════════════════════════════════

Route::get('/', function () {
    return view('landing');
})->name('Home');

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.attempt');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function () {
    return redirect()->route('login');
})->name('register.process');


// ═══════════════════════════════════════════════════════════════════════════
// DASHBOARD
// Semua role yang sudah login
// ═══════════════════════════════════════════════════════════════════════════

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

});


// ═══════════════════════════════════════════════════════════════════════════
// ADMIN + OWNER
// MASTER DATA + FULL CRUD PAKET & LAYANAN
// ═══════════════════════════════════════════════════════════════════════════

Route::middleware(['auth', 'role:Admin,Owner'])->group(function () {

    // ─── PELANGGAN ────────────────────────────────────────────────────────
    // Read
    Route::get('/pelanggan', [CustomerController::class, 'index'])
        ->name('pelanggan.index');

    // Update
    Route::get('/pelanggan/{pelanggan}/edit', [CustomerController::class, 'edit'])
        ->name('pelanggan.edit');

    Route::put('/pelanggan/{pelanggan}', [CustomerController::class, 'update'])
        ->name('pelanggan.update');


    // ─── PAKET ────────────────────────────────────────────────────────────
    // FULL CRUD

    Route::get('/paket', [PackageController::class, 'index'])
        ->name('paket.index');

    Route::post('/paket', [PackageController::class, 'store'])
        ->name('paket.store');

    Route::get('/paket/{paket}/edit', [PackageController::class, 'edit'])
        ->name('paket.edit');

    Route::put('/paket/{paket}', [PackageController::class, 'update'])
        ->name('paket.update');

    Route::delete('/paket/{paket}', [PackageController::class, 'destroy'])
        ->name('paket.destroy');


    // ─── LAYANAN ──────────────────────────────────────────────────────────
    // FULL CRUD

    Route::get('/layanan', [ServiceController::class, 'index'])
        ->name('layanan.index');

    Route::post('/layanan', [ServiceController::class, 'store'])
        ->name('layanan.store');

    Route::get('/layanan/{layanan}/edit', [ServiceController::class, 'edit'])
        ->name('layanan.edit');

    Route::put('/layanan/{layanan}', [ServiceController::class, 'update'])
        ->name('layanan.update');

    Route::delete('/layanan/{layanan}', [ServiceController::class, 'destroy'])
        ->name('layanan.destroy');


    // ─── ORDER ────────────────────────────────────────────────────────────
    // Read + Update

    Route::get('/order', [OrderController::class, 'index'])
        ->name('order.index');

    Route::get('/order/{order}/edit', [OrderController::class, 'edit'])
        ->name('order.edit');

    Route::put('/order/{order}', [OrderController::class, 'update'])
        ->name('order.update');


    // ─── LAPORAN ──────────────────────────────────────────────────────────

    Route::get('/laporan/transaksi', [LaporanController::class, 'transaksi'])
        ->name('laporan.transaksi');

    Route::get('/laporan/pendapatan', [LaporanController::class, 'pendapatan'])
        ->name('laporan.pendapatan');

    Route::get('/laporan/pelanggan', [LaporanController::class, 'pelanggan'])
        ->name('laporan.pelanggan');

});


// ═══════════════════════════════════════════════════════════════════════════
// ADMIN SAJA
// CREATE + DELETE PELANGGAN
// CREATE + DELETE ORDER
// ═══════════════════════════════════════════════════════════════════════════

Route::middleware(['auth', 'role:Admin'])->group(function () {

    // ─── PELANGGAN ────────────────────────────────────────────────────────

    Route::post('/pelanggan', [CustomerController::class, 'store'])
        ->name('pelanggan.store');

    Route::delete('/pelanggan/{pelanggan}', [CustomerController::class, 'destroy'])
        ->name('pelanggan.destroy');


    // ─── ORDER ────────────────────────────────────────────────────────────

    Route::post('/order', [OrderController::class, 'store'])
        ->name('order.store');

    Route::delete('/order/{order}', [OrderController::class, 'destroy'])
        ->name('order.destroy');

});


// ═══════════════════════════════════════════════════════════════════════════
// ADMIN SAJA
// PENGELOLAAN USER & PENGATURAN
// ═══════════════════════════════════════════════════════════════════════════

Route::middleware(['auth', 'role:Admin'])->group(function () {

    // ─── PENGGUNA ─────────────────────────────────────────────────────────

    Route::get('/pengguna', [RoleController::class, 'index'])
        ->name('pengguna.index');

    Route::post('/pengguna', [RoleController::class, 'store'])
        ->name('roles.store');

    Route::get('/pengguna/{role}/edit', [RoleController::class, 'edit'])
        ->name('roles.edit');

    Route::put('/pengguna/{role}', [RoleController::class, 'update'])
        ->name('roles.update');

    Route::delete('/pengguna/{role}', [RoleController::class, 'destroy'])
        ->name('roles.destroy');


    // ─── PENGATURAN ───────────────────────────────────────────────────────

    Route::get('/pengaturan', function () {
        return view('pengaturan.index');
    })->name('pengaturan.index');

});


// ═══════════════════════════════════════════════════════════════════════════
// ANTREAN
// ADMIN + OWNER + KASIR
// READ ONLY
// ═══════════════════════════════════════════════════════════════════════════

Route::middleware(['auth', 'role:Admin,Owner,Kasir'])->group(function () {

    Route::get('/antrean', [QueueController::class, 'index'])
        ->name('antrean.index');

});


// ═══════════════════════════════════════════════════════════════════════════
// STATUS PESANAN
// ADMIN + OWNER + KASIR
// READ + UPDATE
// ═══════════════════════════════════════════════════════════════════════════

Route::middleware(['auth', 'role:Admin,Owner,Kasir'])->group(function () {

    Route::get('/status', [StatusController::class, 'index'])
        ->name('status.index');

    Route::put('/status/{order}', [StatusController::class, 'update'])
        ->name('status.update');

});


// ═══════════════════════════════════════════════════════════════════════════
// PEMBAYARAN
// READ → ADMIN + OWNER + KASIR
// CREATE + UPDATE → ADMIN + KASIR
// ═══════════════════════════════════════════════════════════════════════════

Route::middleware(['auth', 'role:Admin,Owner,Kasir'])->group(function () {

    Route::get('/pembayaran', [PaymentController::class, 'index'])
        ->name('pembayaran.index');

});


// ─── PEMBAYARAN: ADMIN + KASIR SAJA ───────────────────────────────────────

Route::middleware(['auth', 'role:Admin,Kasir'])->group(function () {

    Route::post('/pembayaran', [PaymentController::class, 'store'])
        ->name('pembayaran.store');

    Route::get('/pembayaran/{pembayaran}/edit', [PaymentController::class, 'edit'])
        ->name('pembayaran.edit');

    Route::put('/pembayaran/{pembayaran}', [PaymentController::class, 'update'])
        ->name('pembayaran.update');

});


// ═══════════════════════════════════════════════════════════════════════════
// KASIR
// ADMIN + KASIR
// ═══════════════════════════════════════════════════════════════════════════

Route::middleware(['auth', 'role:Admin,Kasir'])->group(function () {

    Route::get('/kasir', [CashierController::class, 'index'])
        ->name('kasir.index');

    Route::post('/kasir', [CashierController::class, 'store'])
        ->name('kasir.store');

    Route::post('/kasir/pelanggan', [CashierController::class, 'storeCustomer'])
        ->name('kasir.customer.store');

});

// ==========================================================
// PESAN MASUK - LANDING PAGE
// ==========================================================

// Pengunjung landing page dapat mengirim pesan tanpa login
Route::post('/contact-messages', [
    ContactMessageController::class,
    'store'
])->name('contact-messages.store');

// Admin dan Owner dapat melihat pesan dan mengubah status
Route::middleware(['auth', 'role:Admin,Owner'])->group(function () {

    Route::get('/contact-messages', [
        ContactMessageController::class,
        'index'
    ])->name('contact-messages.index');

    Route::put('/contact-messages/{contactMessage}', [
        ContactMessageController::class,
        'update'
    ])->name('contact-messages.update');
});

// Hanya Admin yang dapat menghapus pesan
Route::middleware(['auth', 'role:Admin'])->group(function () {

    Route::delete('/contact-messages/{contactMessage}', [
        ContactMessageController::class,
        'destroy'
    ])->name('contact-messages.destroy');
});

Route::post('/contact-messages', [
    ContactMessageController::class,
    'store'
])->name('contact-messages.store');
