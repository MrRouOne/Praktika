<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add('GET', '/', [Controller\Site::class, 'index']);
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/group', [Controller\Curator::class, 'group'])->middleware('curator');
Route::add('GET', '/academic_performance', [Controller\Curator::class, 'academic_performance'])
    ->middleware('curator');
Route::add(['GET', 'POST'], '/academic_performance_form', [Controller\Curator::class, 'academic_performance_form'])
    ->middleware('curator');
Route::add('GET', '/performance_discipline', [Controller\Curator::class, 'performance_discipline'])
    ->middleware('curator');
Route::add('GET', '/disciplines_list', [Controller\Curator::class, 'disciplines_list'])
    ->middleware('curator');
Route::add(['GET', 'POST'], '/disciplines_list_form', [Controller\Curator::class, 'disciplines_list_form'])
    ->middleware('curator');
Route::add(['GET', 'POST'], '/disciplines_connect', [Controller\Personal::class, 'disciplines_connect'])
    ->middleware('personal');
Route::add(['GET', 'POST'], '/performance_fill', [Controller\Personal::class, 'performance_fill'])
    ->middleware('personal');
Route::add(['GET', 'POST'], '/curriculums_add', [Controller\Personal::class, 'curriculums_add'])
    ->middleware('personal');
Route::add(['GET', 'POST'], '/users_add', [Controller\Admin::class, 'users_add'])
    ->middleware('admin');
Route::add(['GET', 'POST'], '/disciplines_add', [Controller\Admin::class, 'disciplines_add'])
    ->middleware('admin');
Route::add(['GET', 'POST'], '/group_add', [Controller\Admin::class, 'group_add'])
    ->middleware('admin');
Route::add(['GET', 'POST'], '/student_add', [Controller\Admin::class, 'student_add'])
    ->middleware('admin');
Route::add(['GET'], '/error_403', [Controller\Site::class, 'error_403']);
Route::add(['GET', 'POST'], '/send_report', [Controller\Curator::class, 'send_report'])
    ->middleware('curator');