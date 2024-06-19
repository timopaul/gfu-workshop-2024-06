<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/users', [UsersController::class, 'index'])
    ->middleware(Authorize::using('index-users'))
    ->name('users.index');

Route::get('/users/create', [UsersController::class, 'form'])
    ->middleware(Authorize::using('create-users'))
    ->name('users.create');

Route::patch('/users/create', [UsersController::class, 'create'])
    ->middleware(Authorize::using('create-users'))
    ->name('users.save');

Route::get('/users/{user}/edit', [UsersController::class, 'form'])
    ->middleware(Authorize::using('edit-users'))
    ->name('users.edit');

Route::patch('/users/update', [UsersController::class, 'update'])
    ->middleware(Authorize::using('edit-users'))
    ->name('users.update');

Route::get('/users/{user}/remove', [UsersController::class, 'remove'])
    ->middleware(Authorize::using('remove-users'))
    ->name('users.remove');
