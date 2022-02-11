<?php

use Src\Route;
Route::group('/api', function () {
    Route::add('GET', '/', [Controller\Api::class, 'index']);
    Route::add('POST', '/echo', [Controller\Api::class, 'echo']);
    Route::add('POST', '/login', [Controller\Api::class, 'login']);
    Route::add('GET', '/group', [Controller\Api::class, 'group'])->middleware('token','curatorApi');
});