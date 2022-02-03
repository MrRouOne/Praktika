<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add('GET', '/', [Controller\Site::class, 'index']);
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/group', [Controller\Site::class, 'group']);
Route::add('GET', '/academic_performance', [Controller\Site::class, 'academic_performance']);
Route::add('GET', '/performance_discipline', [Controller\Site::class, 'performance_discipline']);
Route::add('GET', '/disciplines_list', [Controller\Site::class, 'disciplines_list']);
Route::add(['GET', 'POST'], '/disciplines_connect', [Controller\Site::class, 'disciplines_connect']);
Route::add(['GET', 'POST'], '/performance_fill', [Controller\Site::class, 'performance_fill']);
Route::add(['GET', 'POST'], '/curriculums_add', [Controller\Site::class, 'curriculums_add']);
Route::add(['GET', 'POST'], '/users_add', [Controller\Site::class, 'users_add']);
Route::add(['GET', 'POST'], '/disciplines_add', [Controller\Site::class, 'disciplines_add']);
Route::add(['GET', 'POST'], '/group_add', [Controller\Site::class, 'group_add']);
Route::add(['GET', 'POST'], '/student_add', [Controller\Site::class, 'student_add']);