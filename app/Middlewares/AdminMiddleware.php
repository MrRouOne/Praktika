<?php

namespace Middlewares;

use Model\Role;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\View;

class AdminMiddleware
{
    public function handle(Request $request)
    {
        //Если пользователь не админ, то редирект на страницу с ошибкой
        if (!Auth::checkRole('admin')) {
            app()->route->redirect('/error_403');
        }
    }
}
