<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\FormController;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\CompanyRegistrationController;

Route::get('/register-company', [CompanyRegistrationController::class, 'create'])->name('company.register');
Route::post('/register-company', [CompanyRegistrationController::class, 'store']);


Route::post('/submit', [FormController::class, 'handleForm']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
