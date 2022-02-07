<?php

namespace Controller;

use Model\Educational_plan;
use Model\Report;
use Model\Academic_performance;
use Model\Discipline;
use Model\Rate;
use Model\Role;
use Model\Student;
use Model\Students_group;
use Src\View;
use Src\Request;
use Model\User;
use Model\Discipline_title;
use Src\Auth\Auth;
use Src\Validator\Validator;


class Site
{
    public function index(Request $request): string
    {
        return (new View())->render('site.index');
    }

    # Куратор

    public function group(Request $request): string
    {
        $students = Student::where('students_group', Students_group::where('user', Auth::user()['id'])->first()['id'])->get();
        $group = Students_group::where('user', Auth::user()['id'])->first()['title'];

        if ($request->method === 'GET') {

            if (!empty($request->all()['lastname'])) {
                $students = Student::where('lastname', $request->all()['lastname'])->get();
                return (new View())->render('site.group', ['students' => $students, 'group' => $group]);
            }


            return (new View())->render('site.group', ['students' => $students, 'group' => $group]);
        }

        app()->route->redirect('/login');
        return 0;
    }

    public function send_report(Request $request): string
    {
        if (!isset($request->all()['educational_plan'])) {
            $request->set('educational_plan', '');
        }

        $group = Students_group::where('user', Auth::user()['id'])->first()['id'];
        $educational_plan = Educational_plan::where('students_group', $group)->get();
        if ($request->method === 'GET') {

            return (new View())->render('site.send_report', ['educational_plans' => $educational_plan]);
        }

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'educational_plan' => ['required', 'integer'],
                'image' => ['required'],
            ], [
                'integer' => 'Поле :field должно быть цифрой',
                'required' => 'Поле :field пусто',
            ]);

            if ($validator->fails()) {
                return (new View())->render('site.send_report',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE), 'educational_plans' => $educational_plan]);
            }

            $target_file = Report::getRootReport() . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

            file_put_contents(
        __DIR__."\\txt.txt",
                $_FILES["image"]["tmp_name"]
            );

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $message = "The file " . basename($_FILES["imageUpload"]["image"]) . " has been uploaded.";
            } else {
                return (new View())->render('site.send_report',
                    ['message' => "The file " . basename($_FILES["imageUpload"]["image"]) . " has been uploaded.", 'educational_plans' => $educational_plan]);
            }

            $image = basename($_FILES["image"]["name"], ".jpg");

            if (Report::create([$request->all()['educational_plan'], $image])) {
                return (new View())->render('site.send_report',
                    ['message' => "<p style='color: green'>Отчёт успешно отправлен!</p>", 'educational_plans' => $educational_plan]);
            }

            return (new View())->render('site.send_report', ['educational_plans' => $educational_plan]);
        }

        return (new View())->render('site.send_report');
    }

    public function academic_performance_form(Request $request): string
    {
        $student = Student::where('id', $request->all()['id'])->first();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'course' => ['required', 'integer'],
                'semester' => ['required', 'integer', 'semester'],
            ], [
                'semester' => 'Поле :field не должно быть больше 2',
                'integer' => 'Поле :field должно быть цифрой',
                'required' => 'Поле :field пусто',
            ]);
            if ($validator->fails()) {
                return (new View())->render('site.academic_performance_form',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE), 'student' => $student]);
            }
            $id = $request->all()['id'];
            $course = $request->all()['course'];
            $semester = $request->all()['semester'];
            app()->route->redirect("/academic_performance?id=$id&course=$course&semester=$semester");
            return 0;
        }

        if ($request->method === 'GET') {
            return (new View())->render('site.academic_performance_form', ['student' => $student]);
        }


        app()->route->redirect('/login');
        return 0;
    }

    public function academic_performance(Request $request): string
    {
        if ($request->method === 'GET') {
            $student = Student::where('id', $request->all()['id'])->first();
            $educational_plan = Educational_plan::where(['students_group' => $student['students_group'],
                'semester' => $request->all()['semester'], 'course' => $request->all()['course']])->first();

            $academic_performances = Academic_performance::where('student', $request->all()['id'])->get();
            $disciplines = [];
            foreach ($academic_performances as $item) {
                $discipline = Discipline::where(['id' => $item['discipline'], 'educational_plan' => $educational_plan['id']])->first();
                if (!empty($discipline)) {
                    $disciplines[] = $discipline;
                }
            }

            if (!empty($disciplines)) {
                return (new View())->render('site.academic_performance', ['student' => $student, 'disciplines' => $disciplines]);
            }
            app()->route->redirect("/academic_performance_form?id=$student->id&message=Некорректные данные");
            return 0;
        }


        app()->route->redirect('/login');
        return 0;
    }

    public function performance_discipline(Request $request): string
    {
        if ($request->method === 'GET') {
            $discipline = Discipline::where('id', $request->all()['id'])->first();
            $academic_performances = Academic_performance::where('discipline', $request->all()['id'])->get();
            $students = [];
            foreach ($academic_performances as $item) {
                $student = Student::where('id', $item['student'])->first();
                if (!empty($student)) {
                    $students[] = $student;
                }
            }


            return (new View())->render('site.performance_discipline', ['discipline' => $discipline, 'students' => $students]);

        }

        app()->route->redirect('/login');
        return 0;

    }

    public function disciplines_list_form(Request $request): string
    {
        $group = Students_group::where('user', Auth::user()['id'])->first();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'course' => ['required', 'integer'],
                'semester' => ['required', 'integer', 'semester'],
            ], [
                'semester' => 'Поле :field не должно быть больше 2',
                'integer' => 'Поле :field должно быть цифрой',
                'required' => 'Поле :field пусто',
            ]);
            if ($validator->fails()) {
                return (new View())->render('site.disciplines_list_form',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE), 'group' => $group]);
            }

            $course = $request->all()['course'];
            $semester = $request->all()['semester'];

            app()->route->redirect("/disciplines_list?id=$group->id&course=$course&semester=$semester");
            return 0;
        }

        if ($request->method === 'GET') {
            return (new View())->render('site.disciplines_list_form', ['group' => $group]);
        }


        app()->route->redirect('/login');
        return 0;

    }

    public function disciplines_list(Request $request): string
    {
        if ($request->method === 'GET') {
            $group = Students_group::where('id', $request->all()['id'])->first();
            $educational_plan = Educational_plan::where(['students_group' => $group['id'],
                'semester' => $request->all()['semester'], 'course' => $request->all()['course']])->first();

            $disciplines = Discipline::where('educational_plan', $educational_plan['id'])->get();

            if (!empty($disciplines[0])) {
                return (new View())->render('site.disciplines_list', ['group' => $group, 'disciplines' => $disciplines]);
            }
            app()->route->redirect("/disciplines_list_form?message=Некорректные данные");
            return 0;
        }


        app()->route->redirect('/login');
        return 0;
    }

    # Персонал

    public function disciplines_connect(Request $request): string
    {

        if (!isset($request->all()['discipline_title'])) {
            $request->set('discipline_title', '');
        }
        if (!isset($request->all()['educational_plan'])) {
            $request->set('educational_plan', '');
        }

        $discipline_titles = Discipline_title::all();
        $educational_plans = Educational_plan::all();


        if ($request->method === 'GET') {
            return (new View())->render('site.disciplines_connect', ['discipline_titles' => $discipline_titles,
                'educational_plans' => $educational_plans]);
        }

        if ($request->method === 'POST') {
            if (!empty($request->all()['educational_plan']) and !empty($request->all()['discipline_title'])) {
                $educational_plan = Educational_plan::where('id', $request->get('educational_plan'))->first()['title'];
                $discipline_title = Discipline_title::where('id', $request->get('discipline_title'))->first()['title'];

                $type = $request->get('type',);
                $request->set('title', "$discipline_title ($educational_plan, $type)");
            }

            $validator = new Validator($request->all(), [
                'discipline_title' => ['required', 'integer'],
                'educational_plan' => ['required', 'integer'],
                'hours' => ['required', 'integer'],
                'type' => ['russian'],
            ], [
                'russian' => 'Поле :field должно содержать только кириллицу',
                'integer' => 'Поле :field должно быть цифрой',
                'required' => 'Поле :field пусто',
            ]);
            if ($validator->fails()) {
                return (new View())->render('site.disciplines_connect',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE), 'discipline_titles' => $discipline_titles,
                        'educational_plans' => $educational_plans]);
            }

            if (Discipline::create($request->except(['csrf_token']))) {
                return (new View())->render('site.disciplines_connect',
                    ['message' => "<p style='color: green'>Дисциплина успешно связана!</p>", 'discipline_titles' => $discipline_titles,
                        'educational_plans' => $educational_plans]);
            }
        }
        return (new View())->render('site.disciplines_connect');
    }

    public function performance_fill(Request $request): string
    {
        if (!isset($request->all()['student'])) {
            $request->set('student', '');
        }

        if (!isset($request->all()['discipline'])) {
            $request->set('discipline', '');
        }

        if (!isset($request->all()['rate'])) {
            $request->set('rate', '');
        }

        $students = Student::all();
        $disciplines = Discipline::all();
        $rates = Rate::all();


        if ($request->method === 'GET') {
            return (new View())->render('site.performance_fill', ['students' => $students, 'disciplines' => $disciplines,
                'rates' => $rates]);
        }

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'student' => ['required', 'integer'],
                'discipline' => ['required', 'integer'],
                'rate' => ['required', 'integer'],
            ], [
                'integer' => 'Поле :field должно быть цифрой',
                'required' => 'Поле :field пусто',
            ]);
            if ($validator->fails()) {
                return (new View())->render('site.performance_fill',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE), 'students' => $students,
                        'disciplines' => $disciplines, 'rates' => $rates]);
            }

            if (Academic_performance::create($request->except(['csrf_token']))) {
                return (new View())->render('site.performance_fill',
                    ['message' => "<p style='color: green'>Учебный план успешно добавлен!</p>", 'students' => $students,
                        'disciplines' => $disciplines, 'rates' => $rates]);
            }
        }

        return (new View())->render('site.performance_fill');
    }

    public function curriculums_add(Request $request): string
    {
        if (!isset($request->all()['students_group'])) {
            $request->set('students_group', '');
        }

        $groups = Students_group::all();


        if ($request->method === 'GET') {
            return (new View())->render('site.curriculums_add', ['groups' => $groups]);
        }

        if ($request->method === 'POST') {
            if (!empty($request->all()['students_group'])) {
                $group = Students_group::where('id', $request->get('students_group'))->first()['title'];
                $semester = $request->get('semester');
                $course = $request->get('course');
                $request->set('title', "Группа $group, семестр $semester, курс $course");
            }

            $validator = new Validator($request->all(), [
                'students_group' => ['required', 'integer'],
                'course' => ['required', 'integer'],
                'semester' => ['required', 'integer', 'semester'],
            ], [
                'semester' => 'Поле :field не должно быть больше 2',
                'integer' => 'Поле :field должно быть цифрой',
                'required' => 'Поле :field пусто',
            ]);

            if ($validator->fails()) {
                return (new View())->render('site.curriculums_add',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE), 'groups' => $groups]);
            }


            if (Educational_plan::create($request->except(['csrf_token']))) {
                return (new View())->render('site.curriculums_add',
                    ['message' => "<p style='color: green'>Учебный план успешно добавлен!</p>", 'groups' => $groups]);
            }
        }
        return (new View())->render('site.curriculums_add');
    }


    # Админ

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

    public function error_403(Request $request): string
    {
        return (new View())->render('site.error_403');
    }


    public function hello(): string
    {
        return (new View())->render('site.hello', ['message' => 'hello working']);
    }


    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required']
            ], [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]);

            if ($validator->fails()) {
                return (new View())->render('site.signup',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (User::create($request->all())) {
                app()->route->redirect('/login');
            }
        }
        return (new View())->render('site.signup');
    }


    public function login(Request $request): string
    {
        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return (new View())->render('site.login');
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return (new View())->render('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/');
    }
}
