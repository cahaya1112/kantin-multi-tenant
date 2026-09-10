<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function (string $canteen) {
    return view('customer.home', ['canteen' => $canteen]);
})->name('home');

// Temporary Closure untuk status order
Route::get('/order', function () {
    return view('customer.order-status');
})->name('order.show');