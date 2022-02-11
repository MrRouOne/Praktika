<?php

namespace Controller;

use Model\StudentsGroup;
use Src\Auth\Auth;
use Src\Request;
use Src\View;
use Model\User;
use Token\BearerToken;

class Api
{
    public function index(): void
    {
        $posts = User::all()->toArray();

        (new View())->toJSON($posts);
    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }

    public function login(Request $request): void
    {
        if (!isset($request->all()['login']) or !isset($request->all()['password'])) {
            (new View())->toJSON(["error" => "Empty password or login"]);
        }

        if (Auth::attemptWithoutLogin($request->all())) {
            $user = User::where('login', $request->all()['login']);
            $user->update(['token' => md5(time())]);
            (new View())->toJSON(["token" => $user->first()['token']]);
        }
        (new View())->toJSON(["error" => "Incorrect data"]);

    }

    public function logout(Request $request): void
    {
        BearerToken::getUser()->update(['token' => NULL]);

        (new View())->toJSON(["message" => 'your token destroy']);


    }

    public function group(): void
    {
        $group = BearerToken::getUser()['group'];
        $students = StudentsGroup::find($group['id'])->students;

        (new View())->toJSON(['Students' => $students]);
    }
}
