<?php

namespace Middlewares;

use Model\User;
use Src\Request;
use Src\View;

class TokenMiddleware
{
    public function handle(Request $request)
    {
        if (!isset(getallheaders()['Authorization'])) {
            return (new View())->toJSON(['error' => 'Empty token']);
        }

        $token = explode(' ', getallheaders()['Authorization'])[1];

        if (empty(User::where('token', $token)->first())) {
            return (new View())->toJSON(['error' => 'Invalid token']);
        }

    }
}
