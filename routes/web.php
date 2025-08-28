<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataBankController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\IndentController;
use App\Http\Controllers\LetterOfCreditController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\DebitNoteController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\UserController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware([AdminMiddleware::class])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Data Bank & Sourcing
    Route::prefix('data-bank')->name('dataBank.')->group(function () {
        Route::get('/', [DataBankController::class, 'index'])->name('index');
    });

    // CRM
    Route::prefix('crm')->name('crm.')->group(function () {
        Route::resource('customers', CustomerController::class)->only(['index', 'show']);
        Route::resource('principals', PrincipalController::class)->only(['index', 'show']);
        Route::resource('products', ProductController::class)->only(['index', 'show']);
    });

    // Sales Ops
    Route::resource('quotations', QuotationController::class)->only(['index', 'show']);
    Route::get('quotations/{quotation}/go-to-indent', [QuotationController::class, 'goToIndent'])->name('quotations.goToIndent');

    Route::resource('indents', IndentController::class)->only(['index', 'show']);
    Route::get('indents/{indent}/go-to-lc', [IndentController::class, 'goToLc'])->name('indents.goToLc');

    Route::resource('lcs', LetterOfCreditController::class)->only(['index', 'show']);
    Route::get('lcs/{lc}/go-to-shipment', [LetterOfCreditController::class, 'goToShipment'])->name('lcs.goToShipment');

    // Logistics
    Route::resource('shipments', ShipmentController::class)->only(['index', 'show']);
    Route::get('shipments/{shipment}/go-to-debit-note', [ShipmentController::class, 'goToDebitNote'])->name('shipments.goToDebitNote');

    // Finance
    Route::resource('debit-notes', DebitNoteController::class)->only(['index', 'show']);
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('accounts', [AccountsController::class, 'index'])->name('accounts.index');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('export/{slug}', [ReportController::class, 'export'])->name('export');

        // Detailed Reports
        Route::get('pareto-analysis', [ReportController::class, 'paretoAnalysis'])->name('pareto-analysis');
        Route::get('principal-product-volume', [ReportController::class, 'principalProductVolume'])->name('principal-product-volume');
        Route::get('product-principal-engagement', [ReportController::class, 'productPrincipalEngagement'])->name('product-principal-engagement');
        Route::get('indents-vs-shipments', [ReportController::class, 'indentsVsShipments'])->name('indents-vs-shipments');
        Route::get('customer-business-volume', [ReportController::class, 'customerBusinessVolume'])->name('customer-business-volume');
        Route::get('outstanding-payments', [ReportController::class, 'outstandingPayments'])->name('outstanding-payments');
        Route::get('lc-expiry-analysis', [ReportController::class, 'lcExpiryAnalysis'])->name('lc-expiry-analysis');
    });

    // Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('teams', [AdminController::class, 'teams'])->name('teams');
        Route::get('users', [AdminController::class, 'users'])->name('users');
        Route::get('parameters', [AdminController::class, 'parameters'])->name('parameters');
    });

    // Legacy routes (keeping for compatibility)
    Route::resource('users', UserController::class);
});

Route::get('test', function () {
    return view('welcome');
})->name('test');

Route::get('load-modal', function () {
    return view('load-modal');
})->name('load-modal');
