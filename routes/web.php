<?php

use App\Livewire\Admin\Category\CategoryIndex;
use App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', Dashboard::class)->name('dashboard.index');
    Route::get('/categories', CategoryIndex::class)->name('categories.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
