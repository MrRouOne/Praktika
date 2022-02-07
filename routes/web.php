<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add('GET', '/', [Controller\Site::class, 'index']);
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/group', [Controller\Site::class, 'group'])->middleware('curator');
Route::add('GET', '/academic_performance', [Controller\Site::class, 'academic_performance'])->middleware('curator');
Route::add(['GET', 'POST'], '/academic_performance_form', [Controller\Site::class, 'academic_performance_form'])->middleware('curator');
Route::add('GET', '/performance_discipline', [Controller\Site::class, 'performance_discipline'])->middleware('curator');
Route::add('GET', '/disciplines_list', [Controller\Site::class, 'disciplines_list'])->middleware('curator');
Route::add(['GET', 'POST'], '/disciplines_list_form', [Controller\Site::class, 'disciplines_list_form'])->middleware('curator');
Route::add(['GET', 'POST'], '/disciplines_connect', [Controller\Site::class, 'disciplines_connect'])->middleware('personal');
Route::add(['GET', 'POST'], '/performance_fill', [Controller\Site::class, 'performance_fill'])->middleware('personal');
Route::add(['GET', 'POST'], '/curriculums_add', [Controller\Site::class, 'curriculums_add'])->middleware('personal');
Route::add(['GET', 'POST'], '/users_add', [Controller\Site::class, 'users_add'])->middleware('admin');
Route::add(['GET', 'POST'], '/disciplines_add', [Controller\Site::class, 'disciplines_add'])->middleware('admin');
Route::add(['GET', 'POST'], '/group_add', [Controller\Site::class, 'group_add'])->middleware('admin');
Route::add(['GET', 'POST'], '/student_add', [Controller\Site::class, 'student_add'])->middleware('admin');
Route::add(['GET'], '/error_403', [Controller\Site::class, 'error_403']);
Route::add(['GET', 'POST'], '/send_report', [Controller\Site::class, 'send_report'])->middleware('curator');