<?php

namespace Controller;

use Model\AcademicPerformance;
use Model\Discipline;
use Model\EducationalPlan;
use Model\Report;
use Model\Student;
use Model\StudentsGroup;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\Validator\Validator;
use Src\View;
use function FileWork\fileWork;

class Curator
{
    public function group(Request $request): string
    {
        if ($request->method !== 'GET') {
            return app()->route->redirect('/login');
        }

        Site::setSelect($request, "lastname");

        $group = User::find(Auth::user()['id'])->group;
        $students = StudentsGroup::find($group->id)->students;

        if (!empty($request->get('lastname'))) {
            $students = $students->where('lastname', $request->get('lastname'));
            return (new View())->render('site.group', ['students' => $students, 'group' => $group->title]);
        }

        return (new View())->render('site.group', ['students' => $students, 'group' => $group->title]);
    }

    public function send_report(Request $request): string
    {
        Site::setSelect($request, "educational_plan");

        $group = User::find(Auth::user()['id'])->group;
        $educational_plan = StudentsGroup::find($group->id)->educationalPlans;

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'educational_plan' => ['required', 'integer'],
                'image' => ['required'],
            ], [
                'integer' => 'Поле :field должно быть цифрой',
                'required' => 'Поле :field пусто',
            ]);

            if ($validator->fails()) {
                return (new View())->render('site.send_report', ['message' => json_encode($validator->errors(),
                    JSON_UNESCAPED_UNICODE), 'educational_plans' => $educational_plan]);
            }

            $path = app()->settings->getUploadPath();

            if (fileWork()->checkUpload('image',$path,'out')) {

                if (Report::create(['educational_plan' => $request->get('educational_plan'),
                    'image' =>  fileWork()->rootToUpload('image',$path,'this')])) {
                    return (new View())->render('site.send_report',
                        ['message' => "<p style='color: green'>Отчёт успешно отправлен!</p>",
                            'educational_plans' => $educational_plan]);
                }
            }

            return (new View())->render('site.send_report',
                ['message' => "Ошибка! Файл не был загружен!", 'educational_plans' => $educational_plan]);
        }

        if ($request->method === 'GET') {
            return (new View())->render('site.send_report', ['educational_plans' => $educational_plan]);
        }

        return app()->route->redirect('/login');
    }

    public function academic_performance_form(Request $request): string
    {
        $student = Student::find($request->get('id'));

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

            $id = $request->get('id');
            $course = $request->get('course');
            $semester = $request->get('semester');

            return app()->route->redirect("/academic_performance?id=$id&course=$course&semester=$semester");
        }

        if ($request->method === 'GET') {
            return (new View())->render('site.academic_performance_form', ['student' => $student]);
        }

        return app()->route->redirect('/login');
    }

    public function academic_performance(Request $request): string
    {
        if ($request->method !== 'GET') {
            return app()->route->redirect('/login');
        }

        $student = Student::find($request->get('id'));
        $educational_plan = EducationalPlan::where(['students_group' => $student['students_group'],
            'semester' => $request->get('semester'), 'course' => $request->get('course')])->first();
        $academic_performances = Student::find($request->get('id'))->academicPerformances;

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

        return app()->route->redirect("/academic_performance_form?id=$student->id&message=Некорректные данные");
    }

    public function performance_discipline(Request $request): string
    {
        if ($request->method !== 'GET') {
            return app()->route->redirect('/login');
        }

        $discipline = Discipline::find($request->get('id'));
        $academic_performances = AcademicPerformance::where('discipline', $request->get('id'))->get();

        $students = [];
        foreach ($academic_performances as $item) {
            $student = Student::find($item['student']);
            if (!empty($student)) {
                $students[] = $student;
            }
        }

        return (new View())->render('site.performance_discipline', ['discipline' => $discipline, 'students' => $students]);
    }

    public function disciplines_list_form(Request $request): string
    {
        $group = User::find(Auth::user()['id'])->group;

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

            $course = $request->get('course');
            $semester = $request->get('semester');

            return app()->route->redirect("/disciplines_list?id=$group->id&course=$course&semester=$semester");
        }

        if ($request->method === 'GET') {
            return (new View())->render('site.disciplines_list_form', ['group' => $group]);
        }

        return app()->route->redirect('/login');
    }

    public function disciplines_list(Request $request): string
    {
        if ($request->method !== 'GET') {
            return app()->route->redirect('/login');
        }

        $group = User::find(Auth::user()['id'])->group;
        $educational_plan = EducationalPlan::where(['students_group' => $group['id'],
            'semester' => $request->get('semester'), 'course' => $request->get('course')])->first();
        $disciplines = Discipline::where('educational_plan', $educational_plan['id'])->get();

        if (!empty($disciplines[0])) {
            return (new View())->render('site.disciplines_list', ['group' => $group, 'disciplines' => $disciplines]);
        }

        return app()->route->redirect("/disciplines_list_form?message=Некорректные данные");
    }
}