<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BankTransferController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileManageController;
use Illuminate\Support\Facades\Route;


Route::get('login_client', [ClientController::class, 'loginClient'])->name('login_client');
Route::post('check', [ClientController::class, 'check'])->name('check_client');
Route::get('/register_client', [ClientController::class, 'showRegistrationForm'])->name('register');
Route::post('/register_client', [ClientController::class, 'register']);
Route::post('/contact', [ContactFormController::class, 'processForm'])->name('client_contact');

Route::prefix('client')->middleware('client')->group(function (){

    Route::get('client-profiles',[ClientController::class, 'clientprofiles'])->name('client_profiles');
    Route::get('/edit_client_profile', [ClientController::class, 'editProfile'])->name('edit_profile');
    Route::post('/update_client_profile', [ClientController::class, 'updateProfile'])->name('update_profile');
    Route::post('client-logout', [ClientController::class, 'logoutClient'])->name('client_logout');
    Route::get('/purchase/{id}', [ClientController::class, 'showPurchasePage'])->name('purchase');

    Route::get('/stripe/{id}', [StripePaymentController::class, 'stripe'])->name('stripe');
    Route::post('/stripe/post/{id}', [StripePaymentController::class, 'stripePost'])->name('stripe.post');


    Route::post('/cart/add/{profileId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cartview');
    Route::post('/cart/remove/{cartItemId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    
    
    Route::get('go-payment', [PaymentController::class, 'goPayment'])->name('payment.go');
    Route::post('pay', [PaymentController::class, 'pay'])->name('payment');
    Route::get('success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('error', [PaymentController::class, 'error'])->name('payment.error');

    Route::post('/pay-total', [PaymentController::class, 'payTotal'])->name('payment_total');
    Route::get('/payment/success-total', [PaymentController::class, 'successTotal'])->name('payment.success.total');

    Route::get('/banktransfer_form', [BankTransferController::class, 'showBankTransferForm'])->name('banktransfer_form');
    Route::post('/submitbank_transfer', [BankTransferController::class, 'submitBankTransfer'])->name('submitbank_transfer');

});


require __DIR__.'/auth.php';
