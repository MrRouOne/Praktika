<?php

namespace Middlewares;

use Model\Role;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\View;

class CuratorApiMiddleware
{
    public function handle(Request $request)
    {
        if (!(User::checkRole('curator')))
        {
            return (new View())->toJSON(['error' => 'Forbidden for you']);
        }
    }
}

