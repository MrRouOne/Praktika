<?php

namespace Controller;

use Model\Academic_performance;
use Model\Discipline;
use Model\Educational_plan;
use Model\Report;
use Model\Student;
use Model\Students_group;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class Curator
{
    public function group(Request $request): string
    {
        $group = User::find(Auth::user()['id'])->group;
        $students = Students_group::find($group->id)->students;


        if ($request->method === 'GET') {

            if (!empty($request->all()['lastname'])) {
                $students =  $students->where('lastname', $request->all()['lastname']);
                return (new View())->render('site.group', ['students' => $students, 'group' => $group->title]);
            }


            return (new View())->render('site.group', ['students' => $students, 'group' => $group->title]);
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

            $absolute_root = Report::getAbsoluteRoot() . $_FILES['image']['name'];

            if (move_uploaded_file($_FILES['image']['tmp_name'], $absolute_root)) {

                if (Report::create(['educational_plan' => $request->all()['educational_plan'],
                    'image' => Report::getFileRoot() . $_FILES['image']['name']])) {
                    return (new View())->render('site.send_report',
                        ['message' => "<p style='color: green'>Отчёт успешно отправлен!</p>",
                            'educational_plans' => $educational_plan]);

                }

            } else {

                return (new View())->render('site.send_report',
                    ['message' => "Ошибка! Файл не был загружен!", 'educational_plans' => $educational_plan]);

            }
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
}