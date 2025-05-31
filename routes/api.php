<?php

use App\Http\Controllers\RBAC\ManagePermissionController;
use App\Http\Controllers\RBAC\ModuleController;
use App\Http\Controllers\RBAC\PermissionController;
use App\Http\Controllers\RBAC\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CleanInputData;
use App\Http\Middleware\DetectSQLInjection;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware([CleanInputData::class, DetectSQLInjection::class])->group(function () {

    Route::controller(ModuleController::class)->group(function () {
        Route::get('modules', 'index');
        Route::get('modules/{id}', 'show');
        Route::post('modules', 'store');
        Route::put('modules/{id}', 'update');
        Route::delete('modules/{id}', 'destroy');
    });

    Route::controller(PermissionController::class)->group(function () {
        Route::get('permission', 'index');
        Route::get('permission/{id}', 'show');
        Route::post('permission', 'store');
        Route::put('permission/{id}', 'update');
        Route::delete('permission/{id}', 'destroy');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('roles', 'index');
        Route::get('roles/{id}', 'show');
        Route::post('roles', 'store');
        Route::put('roles/{id}', 'update');
        Route::delete('roles/{id}', 'destroy');
    });

    Route::controller(ManagePermissionController::class)->group(function () {

    });



});