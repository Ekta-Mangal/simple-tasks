<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController_old;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManageDataController;
use App\Http\Controllers\UserContoller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {

    // -----------DASHBOARD----------------//
    Route::get('/dashboard', [HomeController::class, 'show'])->name('dashboard');
    Route::get('/graph', [HomeController::class, 'graph'])->name('graph');

    // -----------DATA DISPLAY----------------//
    Route::get('gettabledata', [ManageDataController::class, 'gettabledata'])->name('gettabledata');
    Route::get('managedata/view', [ManageDataController::class, 'detailsview'])->name('managedata.view');
    Route::post('managedata/update', [ManageDataController::class, 'update'])->name('managedata.update');

    // -----------USER PROFILE---------------//
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile');
    Route::get('/profile/list', [ProfileController::class, 'list'])->name('profile.list');

    // -----------MANAGE USER----------------//
    Route::middleware('CheckAdmin')->group(function () {
        Route::get('manageuser/list', [UserContoller::class, 'list'])->name('manageuser.list');
        Route::get('manageuser/add', [UserContoller::class, 'add'])->name('manageuser.add');
        Route::post('manageuser/postadd', [UserContoller::class, 'postadd'])->name('manageuser.postadd');
        Route::get('manageuser/edit', [UserContoller::class, 'editUser'])->name('manageuser.edit');
        Route::post('manageuser/update', [UserContoller::class, 'update'])->name('manageuser.update');
        Route::get('manageuser/delete', [UserContoller::class, 'delete'])->name('manageuser.delete');
    });

    // -----------MANAGE TASKS----------------//
    Route::get('managetask/list', [TaskController_old::class, 'index'])->name('managetask.list');
    Route::get('managetask/addTask', [TaskController_old::class, 'addTask'])->name('managetask.addTask');
    Route::post('managetask/postTask', [TaskController_old::class, 'postTask'])->name('managetask.postTask');
    Route::get('managetask/editTask', [TaskController_old::class, 'editTask'])->name('managetask.editTask');
    Route::post('managetask/updateTask', [TaskController_old::class, 'updateTask'])->name('managetask.updateTask');
    Route::get('managetask/deleteTask', [TaskController_old::class, 'deleteTask'])->name('managetask.deleteTask');
});

require __DIR__ . '/auth.php';