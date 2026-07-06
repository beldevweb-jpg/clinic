<?php

use Illuminate\Support\Facades\Route;
use Modules\AuditLog\Http\Controllers\AuditLogController;

Route::middleware(['auth'])->group(function () {
    Route::resource('auditlogs', AuditLogController::class)->names('auditlog');
});
