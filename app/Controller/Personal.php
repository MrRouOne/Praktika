<?php

namespace Controller;


use Model\AcademicPerformance;
use Model\Discipline;
use Model\DisciplineTitle;
use Model\EducationalPlan;
use Model\Rate;
use Model\Student;
use Model\StudentsGroup;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class Personal
{
    public function disciplines_connect(Request $request): string
    {
        Site::setSelect($request, "discipline_title");
        Site::setSelect($request, "educational_plan");
        $discipline_titles = DisciplineTitle::all();
        $educational_plans = EducationalPlan::all();

        if ($request->method === 'POST') {

            if (!empty($request->get('educational_plan')) and !empty($request->get('discipline_title'))) {

                $educational_plan = EducationalPlan::find($request->get('educational_plan'))->title;
                $discipline_title = DisciplineTitle::find($request->get('discipline_title'))->title;
                $type = $request->get('type');

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

        if ($request->method === 'GET') {
            return (new View())->render('site.disciplines_connect', ['discipline_titles' => $discipline_titles,
                'educational_plans' => $educational_plans]);
        }

        return app()->route->redirect('/login');
    }

    public function performance_fill(Request $request): string
    {
        Site::setSelect($request, "student");
        Site::setSelect($request, "discipline");
        Site::setSelect($request, "rate");
        $students = Student::all();
        $disciplines = Discipline::all();
        $rates = Rate::all();

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

            if (AcademicPerformance::create($request->except(['csrf_token']))) {
                return (new View())->render('site.performance_fill',
                    ['message' => "<p style='color: green'>Учебный план успешно добавлен!</p>", 'students' => $students,
                        'disciplines' => $disciplines, 'rates' => $rates]);
            }
        }

        if ($request->method === 'GET') {
            return (new View())->render('site.performance_fill', ['students' => $students, 'disciplines' => $disciplines,
                'rates' => $rates]);
        }

        return app()->route->redirect('/login');
    }

    public function curriculums_add(Request $request): string
    {
        Site::setSelect($request, "students_group");
        $groups = StudentsGroup::all();

        if ($request->method === 'POST') {

            if (!empty($request->get('students_group'))) {
                $group = StudentsGroup::find($request->get('students_group'))->title;
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

            if (EducationalPlan::create($request->except(['csrf_token']))) {
                return (new View())->render('site.curriculums_add',
                    ['message' => "<p style='color: green'>Учебный план успешно добавлен!</p>", 'groups' => $groups]);
            }
        }

        if ($request->method === 'GET') {
            return (new View())->render('site.curriculums_add', ['groups' => $groups]);
        }

        return app()->route->redirect('/login');
    }
}