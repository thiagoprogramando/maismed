<?php

use App\Http\Controllers\Event\EventController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('add-event', [EventController::class, 'addEvent'])->name('add-event');
Route::post('del-event', [EventController::class, 'delEvent'])->name('del-event');
Route::get('graph-calendar', [EventController::class, 'graphCalendar'])->name('graph-calendar');