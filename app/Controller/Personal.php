<?php

namespace Controller;


use Model\Academic_performance;
use Model\Discipline;
use Model\Discipline_title;
use Model\Educational_plan;
use Model\Rate;
use Model\Student;
use Model\Students_group;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class Personal
{
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
}