<?php

use App\Http\Controllers\Api\OrderController; // Import Controller Anda
use Illuminate\Support\Facades\Route;

Route::post('/orders', [OrderController::class, 'store']);
