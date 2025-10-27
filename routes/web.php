<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear-cache-now', function () {
    Artisan::call('optimize:clear');
    return 'All caches cleared successfully 😎';
});