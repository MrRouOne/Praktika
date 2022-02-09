<?php

namespace Middlewares;

use Model\User;
use Src\Request;

class AdminMiddleware
{
    public function handle(Request $request)
    {
        //Если пользователь не админ, то редирект на страницу с ошибкой
        if (!User::checkRole('admin')) {
            app()->route->redirect('/error_403');
        }
    }
}
