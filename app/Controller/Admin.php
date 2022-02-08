<?php

namespace Controller;

use Model\Discipline_title;
use Model\Role;
use Model\Student;
use Model\Students_group;
use Model\User;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class Admin
{
    public function users_add(Request $request): string
    {
        if (!isset($request->all()['role'])) {
            $request->set('role', '');
        }

        $roles = Role::all();
        if ($request->method === 'GET') {
            return (new View())->render('site.users_add', ['roles' => $roles]);
        }

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'login' => ['required', 'unique:users,login', 'english'],
                'password' => ['required', 'english'],
                'name' => ['required', 'russian'],
                'lastname' => ['required', 'russian'],
                'patronymic' => ['russian'],
                'date_birth' => ['date'],
                'sex' => ['integer'],
                'role' => ['required', 'integer'],
            ], [
                'date' => 'Поле :field содержит некорректные данные для формы',
                'integer' => 'Поле :field должно быть цифрой',
                'russian' => 'Поле :field должно содержать только кириллицу',
                'english' => 'Поле :field должно содержать только латинские символы и цифры',
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
            if ($validator->fails()) {
                return (new View())->render('site.users_add',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE), 'roles' => $roles]);
            }

            if (User::create($request->except(['csrf_token']))) {
                return (new View())->render('site.users_add',
                    ['message' => "<p style='color: green'>Пользователь успешно добавлен!</p>", 'roles' => $roles]);
            }
        }
        return (new View())->render('site.users_add');
    }

    public function disciplines_add(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'title' => ['required', 'unique:discipline_titles,title',],
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
            if ($validator->fails()) {
                return (new View())->render('site.disciplines_add',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (Discipline_title::create($request->except(['csrf_token']))) {
                return (new View())->render('site.disciplines_add',
                    ['message' => "<p style='color: green'>Название дисциплины успешно добавлено!</p>"]);
            }
        }
        return (new View())->render('site.disciplines_add');

    }

    public function group_add(Request $request): string
    {
        if (!isset($request->all()['user'])) {
            $request->set('user', '');
        }
        $users = User::where('role', Role::where('code', 'curator')->first()['id'])->get();


        if ($request->method === 'GET') {
            return (new View())->render('site.group_add', ['users' => $users]);
        }

        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'title' => ['required', 'integer'],
                'course' => ['required', 'integer'],
                'semester' => ['required', 'integer', 'semester'],
                'user' => ['required', 'unique:students_groups,user', 'integer'],
            ], [
                'semester' => 'Поле :field не должно быть больше 2',
                'integer' => 'Поле :field должно быть цифрой',
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if ($validator->fails()) {
                return (new View())->render('site.group_add',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE), 'users' => $users]);
            }

            if (Students_group::create($request->except(['csrf_token']))) {
                return (new View())->render('site.group_add',
                    ['message' => "<p style='color: green'>Группа успешно добавлена!</p>", 'users' => $users]);
            }
        }

        return (new View())->render('site.group_add');
    }

    public function student_add(Request $request): string
    {
        if (!isset($request->all()['students_group'])) {
            $request->set('students_group', '');
        }
        $groups = Students_group::all();


        if ($request->method === 'GET') {
            return (new View())->render('site.student_add', ['groups' => $groups]);
        }

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required', 'russian'],
                'lastname' => ['required', 'russian'],
                'patronymic' => ['russian'],
                'sex' => ['integer'],
                'date_birth' => ['required', 'date'],
                'address' => ['required',],
                'students_group' => ['required', 'integer'],
            ], [
                'date' => 'Поле :field содержит некорректные данные для формы',
                'integer' => 'Поле :field должно быть цифрой',
                'russian' => 'Поле :field должно содержать только кириллицу',
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);
            if ($validator->fails()) {
                return (new View())->render('site.student_add',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE), 'groups' => $groups]);
            }

            if (Student::create($request->except(['csrf_token']))) {
                return (new View())->render('site.student_add',
                    ['message' => "<p style='color: green'>Студент успешно добавлен!</p>", 'groups' => $groups]);
            }
        }
        return (new View())->render('site.student_add');
    }
}