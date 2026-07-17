<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;


Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::get(
        'user',
        [UserController::class, 'index']
    )->name('user.index');


    Route::get(
        'user/create',
        [UserController::class, 'create']
    )->name('user.create');


    Route::post(
        'user',
        [UserController::class, 'store']
    )->name('user.store');


    Route::get(
        'user/{user}',
        [UserController::class, 'show']
    )->name('user.show');


    // หน้าแก้ไข
    Route::get(
        'user/{user}/edit',
        [UserController::class, 'edit']
    )->name('user.edit');


    // บันทึกแก้ไข
    Route::put(
        'user/{user}',
        [UserController::class, 'update']
    )->name('user.update');


    // ลบ
    Route::delete(
        'user/{user}',
        [UserController::class, 'destroy']
    )->name('user.destroy');
});
