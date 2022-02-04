<?php

namespace Middlewares;

use Model\Role;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\View;

class PersonalMiddleware
{
    public function handle(Request $request)
    {
        //Если пользователь не персонал, то редирект на страницу с ошибкой
        if (!Auth::checkPersonal()) {
            app()->route->redirect('/error_403');
        }
    }
}
