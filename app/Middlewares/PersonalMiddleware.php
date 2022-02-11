<?php

namespace Middlewares;

use Model\User;
use Src\Request;

class PersonalMiddleware
{
    public function handle(Request $request)
    {
        //Если пользователь не персонал, то редирект на страницу с ошибкой
        if (!User::checkRoleCurrent('staff')) {
            app()->route->redirect('/error_403');
        }
    }
}
