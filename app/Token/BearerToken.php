<?php

namespace Token;

use Model\User;

class BearerToken
{
    public static function checkToken(): bool
    {
        if (isset(getallheaders()['Authorization'])) {
            return true;
        }
        return false;
    }

    public static function getToken(): string
    {
        return explode(' ', getallheaders()['Authorization'])[1];
    }

    public static function checkUser(): bool
    {
        if (User::where('token', BearerToken::getToken())->count()) {
            return true;
        }
        return false;
    }

    public static function getUser()
    {
        return User::where('token', BearerToken::getToken())->first();
    }

}
