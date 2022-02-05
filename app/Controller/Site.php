<?php

namespace Controller;

use Model\Post;
use Model\Role;
use Src\View;
use Src\Settings;
use Src\Request;
use Model\User;
use Model\Discipline_title;
use Src\Auth\Auth;
use Src\Validator\Validator;



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
        if (!isset($request->all()['role'])){
            $request->set('role', '');
        }

        $roles = Role::all();
        if ($request->method === 'GET') {
            return (new View())->render('site.users_add',['roles' => $roles]);
        }

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'login' => ['required', 'unique:users,login','english'],
                'password' => ['required','english'],
                'name' => ['required','russian'],
                'lastname' => ['required','russian'],
                'patronymic' => ['russian'],
                'sex' => ['integer'],
                'role' => ['required','integer'],
            ], [
                'integer' => 'Поле :field должно быть цифрой',
                'russian' => 'Поле :field должно содержать только кириллицу',
                'english' => 'Поле :field должно содержать только латинские символы и цифры',
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
            if($validator->fails()){
                $roles = Role::all();
                return new View('site.users_add',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),'roles' => $roles]);
            }

            if (User::create($request->except(['csrf_token']))) {
                return new View('site.users_add',
                    ['message' => "<p style='color: green'>Пользователь успешно добавлен!</p>"]);
            }
        }
        return new View('site.users_add');
    }

    public function disciplines_add(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'title' => ['required', 'unique:discipline_titles,title',],
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
            if($validator->fails()){
                return new View('site.disciplines_add',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (Discipline_title::create($request->except(['csrf_token']))) {
                return new View('site.disciplines_add',
                    ['message' => "<p style='color: green'>Название дисциплины успешно добавлено!</p>"]);
            }
        }
        return new View('site.disciplines_add');

    }

    public function group_add(Request $request): string
    {
        if (!isset($request->all()['user'])){
            $request->set('user', '');
        }

        $roles = Role::all();
        if ($request->method === 'GET') {
            return (new View())->render('site.users_add',['users' => $users]);
        }

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'title' => ['required', 'unique:discipline_titles,title',],
                'course' => ['required', 'unique:discipline_titles,title',],
                'semester' => ['required', 'unique:discipline_titles,title',],
                'user' => ['required', 'unique:discipline_titles,title',],
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
            if($validator->fails()){
                return new View('site.disciplines_add',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (Discipline_title::create($request->except(['csrf_token']))) {
                return new View('site.disciplines_add',
                    ['message' => "<p style='color: green'>Название дисциплины успешно добавлено!</p>"]);
            }
        }

        return new View('site.group_add');
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

//    public function signup(Request $request): string
//    {
//        if ($request->method === 'GET') {
//            return new View('site.signup');
//        }
//
//        if ($request->method === 'POST' && User::where('login', $request->login)->first()) {
//
//            return new View('site.signup', ['message' => 'Логин уже существует']);
//        }
//
//        if ($request->method === 'POST' && User::create($request->all())) {
//            app()->route->redirect('/login');
//        }
//    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if($validator->fails()){
                return new View('site.signup',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (User::create($request->all())) {
                app()->route->redirect('/login');
            }
        }
        return new View('site.signup');
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
