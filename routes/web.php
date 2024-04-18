<?php

use App\Http\Controllers\Access\LoginController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Unit\UnitController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('logon', [LoginController::class, 'logon'])->name('logon');

Route::middleware(['auth'])->group(function () {

    Route::get('/app', [AppController::class, 'app'])->name('app');

    //User
    Route::get('/list-user', [UserController::class, 'list'])->name('list-user');
    Route::get('/profile-user', [UserController::class, 'profile'])->name('profile-user');
    Route::get('/search', [UserController::class, 'search'])->name('search');
    Route::post('create-user', [UserController::class, 'create'])->name('create-user');
    Route::post('update-user', [UserController::class, 'update'])->name('update-user');
    Route::post('delete-user', [UserController::class, 'delete'])->name('delete-user');

    //Unit
    Route::get('/list-unit', [UnitController::class, 'list'])->name('list-unit');
    Route::post('create-unit', [UnitController::class, 'create'])->name('create-unit');
    Route::post('update-unit', [UnitController::class, 'update'])->name('update-unit');
    Route::post('delete-unit', [UnitController::class, 'delete'])->name('delete-unit');

    //Event
    Route::get('/list-event', [EventController::class, 'list'])->name('list-event');
    Route::get('/view-event/{id}', [EventController::class, 'viewEvent'])->name('view-event');
    Route::post('create-event', [EventController::class, 'create'])->name('create-event');
    Route::post('update-event', [EventController::class, 'update'])->name('update-event');
    Route::post('delete-event', [EventController::class, 'delete'])->name('delete-event');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
