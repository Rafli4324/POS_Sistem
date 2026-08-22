<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\MenuController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $today = \Carbon\Carbon::today();
        $totalSalesToday = \App\Models\Sale::whereDate('tanggal_transaksi', $today)->sum('total_harga');
        
        $ordersToday = \App\Models\SaleDetail::whereHas('sale', function($q) use ($today) {
            $q->whereDate('tanggal_transaksi', $today);
        })->sum('jumlah_beli');
        
        $lowStockItems = \App\Models\Menu::where('stok_saat_ini', '<=', 5)->count();
        
        return view('dashboard', compact('totalSalesToday', 'ordersToday', 'lowStockItems'));
    })->name('dashboard');

    Route::resource('menus', MenuController::class);

    Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [App\Http\Controllers\TransactionController::class, 'store'])->name('transactions.store');

    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [App\Http\Controllers\ReportController::class, 'exportCsv'])->name('reports.export');

        Route::get('/forecasts', [App\Http\Controllers\ForecastController::class, 'index'])->name('forecasts.index');
        Route::post('/forecasts/generate', [App\Http\Controllers\ForecastController::class, 'generate'])->name('forecasts.generate');
        Route::post('/forecasts/manual', [App\Http\Controllers\ForecastController::class, 'predictManual'])->name('forecasts.manual');
    });
    
    // API routes for Kasir
    Route::get('/api/recommendations', [App\Http\Controllers\RecommendationController::class, 'getRecommendations'])->name('api.recommendations');
});
