<?php

namespace Controller;

use Model\Post;
use Model\StudentsGroup;
use Src\Auth\Auth;
use Src\Request;
use Src\View;
use Model\User;

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
        if (isset($request->all()['login']) and isset($request->all()['password'])) {
            if (Auth::attempt($request->all())) {
                $user = User::where('login', $request->all()['login']);
                $user->update(['token' => md5(time())]);
                (new View())->toJSON(["token" => $user->first()['token']]);
            }
            (new View())->toJSON(["error" => "Incorrect data"]);
        }
        (new View())->toJSON(["error" => "Empty password or login"]);
    }

    public function group(Request $request): void
    {
        $token = explode(' ', getallheaders()['Authorization'])[1];
        $group = User::where('token', $token)->first()['group'];
        $students = StudentsGroup::find($group['id'])->students;

        (new View())->toJSON(['Students'=>$students]);
    }
}
