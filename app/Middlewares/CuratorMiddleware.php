<?php

namespace Middlewares;

use Model\User;
use Src\Request;

class CuratorMiddleware
{
    public function handle(Request $request)
    {
        //Если пользователь не персонал, то редирект на страницу с ошибкой
        if (!User::checkRoleCurrent('curator')) {
            app()->route->redirect('/error_403');
        }
    }
}
