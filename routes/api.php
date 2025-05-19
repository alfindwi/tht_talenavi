<?php

use App\Http\Controllers\todoController;
use Illuminate\Support\Facades\Route;


Route::post('/todo', [todoController::class, 'store']);
Route::get('/todo/export', [todoController::class, 'exportExcel']);
Route::get('/todo/chart', [todoController::class, 'chartData']);
