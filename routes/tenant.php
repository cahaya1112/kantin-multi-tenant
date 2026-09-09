<?php

// use App\Http\Controllers\Tenant\TenantLedgerExportController;
// use App\Http\Controllers\Tenant\TenantMenuController;
// use App\Models\Tenant; // Komentari sementara karena model belum ada
use Illuminate\Support\Facades\Route;

/**
 * Konteks OPERATOR TENANT (internal). Prefix: tenant/{tenant:slug}, name: tenant.*
 * Middleware auth+verified+tenant (SetTenantContext) + scopeBindings di bootstrap/app.php.
 * {tenant} terikat model Tenant (slug); {menu} scoped di bawah tenant (global scope + relasi).
 */
Route::get('/dashboard', fn ($tenant) => "Dashboard Tenant: " . $tenant)
    ->name('dashboard');

// Route::get('/menus', [TenantMenuController::class, 'index'])->name('menus.index');
// Route::get('/menus/{menu}', [TenantMenuController::class, 'show'])->name('menus.show');
// Route::patch('/menus/{menu}', [TenantMenuController::class, 'update'])->name('menus.update');

Route::get('/menu-manager', fn ($tenant) => "Menu Manager Tenant: " . $tenant)->name('menu-manager');

Route::get('/kitchen', fn ($tenant) => "Kitchen Tenant: " . $tenant)->name('kitchen');

Route::get('/finance', fn ($tenant) => "Finance Tenant: " . $tenant)->name('finance');
// Route::get('/finance/ledger.csv', TenantLedgerExportController::class)->name('finance.export');