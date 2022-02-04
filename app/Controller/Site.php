<?php

namespace Controller;

use Model\Post;
use Model\Role;
use Src\View;
use Src\Request;
use Model\User;
use Src\Auth\Auth;


class Site
{
    public function index(Request $request): string
    {
        return (new View())->render('site.index');
    }

    # Куратор

    public function group(Request $request): string
    {
        return (new View())->render('site.group');
    }

    public function academic_performance(Request $request): string
    {
        return (new View())->render('site.academic_performance');
    }

    public function performance_discipline(Request $request): string
    {
        return (new View())->render('site.performance_discipline');
    }

    public function disciplines_list(Request $request): string
    {
        return (new View())->render('site.disciplines_list');
    }

    # Персонал

    public function disciplines_connect(Request $request): string
    {
        return (new View())->render('site.disciplines_connect');
    }

    public function performance_fill(Request $request): string
    {
        return (new View())->render('site.performance_fill');
    }

    public function curriculums_add(Request $request): string
    {
        return (new View())->render('site.curriculums_add');
    }


    # Админ

    public function users_add(Request $request): string
    {
        $roles = Role::all();
        if ($request->method === 'GET') {
            return (new View())->render('site.users_add',['roles' => $roles]);
        }

        if ($request->method === 'POST' && User::where('login', $request->login)->first()) {

            return new View('site.signup', ['message' => 'Пользователь уже существует']);
        }

        if ($request->method === 'POST' && User::create($request->all())) {
            app()->route->redirect('/users_add');
        }
    }

    public function disciplines_add(Request $request): string
    {
        return (new View())->render('site.disciplines_add');
    }

    public function group_add(Request $request): string
    {
        return (new View())->render('site.group_add');
    }

    public function student_add(Request $request): string
    {
        return (new View())->render('site.student_add');
    }

    public function error_403(Request $request): string
    {
        return (new View())->render('site.error_403');
    }


    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.signup');
        }

        if ($request->method === 'POST' && User::where('login', $request->login)->first()) {

            return new View('site.signup', ['message' => 'Логин уже существует']);
        }

        if ($request->method === 'POST' && User::create($request->all())) {
            app()->route->redirect('/login');
        }
    }

    public function login(Request $request): string
    {
        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/');
    }
}
