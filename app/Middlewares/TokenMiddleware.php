<?php

namespace Middlewares;

use Src\Request;
use Src\View;
use Token\BearerToken;

class TokenMiddleware
{
    public function handle(Request $request)
    {
        if (!BearerToken::checkToken()) {
            return (new View())->toJSON(['error' => 'Empty token']);
        }

        if (!BearerToken::checkUser()) {
            return (new View())->toJSON(['error' => 'Invalid token']);
        }
    }
}
