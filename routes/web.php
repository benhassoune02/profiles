<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileManageController;
use App\Http\Controllers\ClientManageController;
use App\Http\Controllers\PurchasedProfilesController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\TransferBankController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile_destroy');

    Route::get('/all_profiles', [ProfileManageController::class , 'index'])->name('all_profiles');
    Route::get('/search-profiles', [ProfileManageController::class, 'searchProfiles'])->name('search_profiles');
    Route::get('/purchased_profiles', [PurchasedProfilesController::class, 'index'])->name('purchased_profiles.index');
    Route::delete('/cart-profiles/{id}/delete', [PurchasedProfilesController::class, 'deleteCartPurchasedProfile'])->name('delete_cart_purchased_profile');
    Route::get('/profiles/add', [ProfileManageController::class, 'createProfile'])->name('profile_create');
    Route::post('/profiles/add', [ProfileManageController::class, 'storeProfile'])->name('profile_store');
    Route::get('/profiles/edit/{id}', [ProfileManageController::class, 'edit'])->name('profile.edit');
    Route::post('/profiles/edit/{id}', [ProfileManageController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profiles/delete/{id}',[ProfileManageController::class, 'destroyProfile'])->name('destroy_profile');

    Route::get('/all_clients' , [ClientManageController::class, 'index'])->name('all_clients');
    Route::get('/add_client', [ClientManageController::class, 'addClient'])->name('add_client');
    Route::post('/add-client', [ClientManageController::class, 'storeClient'])->name('client_store');
    Route::get('/edit-client/{id}', [ClientManageController::class, 'editClient'])->name('edit_client');
    Route::put('/clients/update/{id}', [ClientManageController::class, 'updateClient'])->name('update_client');


    Route::delete('/destroy-client/{id}', [ClientManageController::class, 'destroyClient'])->name('destroy_client');

    Route::get('/contacts',[ContactFormController::class, 'viewAllContacts'] )->name('all_contacts');
    Route::delete('/contacts/{id}', [ContactFormController::class, 'deleteContact'])->name('delete_contact');



    Route::get('/banktransfers', [TransferBankController::class, 'viewbanktransfers'])->name('banktransfers');
    Route::get('/banktransfers/confirm/{id}', [TransferBankController::class, 'confirmTransfer'])->name('banktransfers.confirm');
    Route::get('/banktransfers/cancel/{id}', [TransferBankController::class, 'cancelTransfer'])->name('banktransfers.cancel');
    Route::delete('/banktransfers/{id}/delete', [TransferBankController::class, 'deleteBankTransfer'])->name('banktransfers.delete');

});

require __DIR__.'/auth.php';
