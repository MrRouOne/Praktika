<?php

namespace Controller;

use Model\Post;
use Src\View;
use Src\Request;
use Model\User;
use Src\Auth\Auth;


class Site
{
    public function index(Request $request): string
    {
        return (new View())->render('site.post');
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

        if($request->method === 'POST' && User::where('login', $request->login)){
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
            app()->route->redirect('/hello');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }
}
