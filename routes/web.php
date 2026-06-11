<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\VendorRegistrationController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\VendorDashboardController;
use App\Http\Controllers\QuotationController;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CheckoutController;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/services', [HomeController::class, 'services'])->name('home');

Route::get('/book', [BookingController::class, 'show'])->name('booking.show');
Route::post('/book', [BookingController::class, 'update'])->name('booking.update');

// Region API
Route::get('/api/regions/cities', function(Illuminate\Http\Request $request) {
    return City::where('province_code', $request->province_code)->get();
});
Route::get('/api/regions/districts', function(Illuminate\Http\Request $request) {
    return District::where('city_code', $request->city_code)->get();
});
Route::get('/api/regions/villages', function(Illuminate\Http\Request $request) {
    return Village::where('district_code', $request->district_code)->get();
});

Route::get('/api/categories/{category}/subcategories', function (App\Models\Category $category) {
    return $category->subcategories()->orderBy('name')->get(['id', 'name', 'category_id']);
});

Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/vendor/{id}/approve', [AdminDashboardController::class, 'approveVendor'])->name('admin.vendor.approve');
    Route::post('/admin/vendor/{id}/reject', [AdminDashboardController::class, 'rejectVendor'])->name('admin.vendor.reject');
    Route::post('/admin/dispute/{id}/resolve', [AdminDashboardController::class, 'resolveDispute'])->name('admin.dispute.resolve');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::post('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');
    
    Route::get('/requests/create', [ServiceRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [ServiceRequestController::class, 'store'])->name('requests.store');
    
    // Service Request State Machine
    Route::post('/requests/{id}/start', [ServiceRequestController::class, 'startWork'])->name('requests.start');
    Route::post('/requests/{id}/finish', [ServiceRequestController::class, 'finishWork'])->name('requests.finish');
    Route::post('/requests/{id}/confirm', [ServiceRequestController::class, 'confirmCompletion'])->name('requests.confirm');
    Route::post('/requests/{id}/dispute', [ServiceRequestController::class, 'reportDispute'])->name('requests.dispute');

    Route::get('/vendor/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');
    Route::post('/requests/{id}/quotations', [QuotationController::class, 'store'])->name('quotations.store');
    Route::post('/quotations/{id}/accept', [QuotationController::class, 'accept'])->name('quotations.accept');

    Route::get('/vendor/register', [VendorRegistrationController::class, 'create'])->name('vendor.register');
    Route::post('/vendor/register', [VendorRegistrationController::class, 'store'])->name('vendor.store');
});

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/vendor-documents', [ProfileController::class, 'updateVendorDocuments'])->name('profile.vendor-documents.update');
});

require __DIR__.'/auth.php';
