<?php

namespace Middlewares;

use Model\Role;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\View;
use Token\BearerToken;

class CuratorApiMiddleware
{
    public function handle()
    {
        if (!(User::checkRole(BearerToken::getUser(),'curator')))
        {
            return (new View())->toJSON(['error' => 'Forbidden for you']);
        }
    }
}

