<?php

use App\Http\Controllers\RBAC\Configuration;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([])->group(function () {
    Route::get('/roleConfiguration', [Configuration::class, "index"]);
});