<?php

use Illuminate\Support\Facades\Route;
use LaraJS\Permission\Controllers\PermissionController;
use LaraJS\Permission\Controllers\RoleController;
use LaraJS\Permission\Enums\PermissionEnum;

// Permission manage permission
Route::group(
    [
        'prefix' => 'api/v1',
        'middleware' => ['auth:sanctum', 'api', 'permission:'.PermissionEnum::MANAGE->name],
    ],
    function () {
        Route::apiResource('roles', RoleController::class)->except('show');
        Route::apiResource('permissions', PermissionController::class)->except('show');
    },
);
