<?php

use Model\StudentsGroup;
use Model\Student;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     * @runInSeparateProcess
     */
    public function testStudentAdd(string $httpMethod, array $userData, string $message): void
    {
        //Выбираем группу из базы данных
        if ($userData['students_group'] === 'group_in_base') {
            $userData['students_group'] = StudentsGroup::get()->first()->id;
        }

        // Создаем заглушку для класса Request.
        $request = $this->createMock(\Src\Request::class);
        // Переопределяем метод all() и свойство method
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;

        //Сохраняем результат работы метода в переменную
        $result = (new \Controller\Admin())->student_add($request);

        if (!empty($result)) {
            //Проверяем варианты с ошибками валидации
            $message = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($message);
            return;
        }

        //Проверяем добавился ли студент в базу данных
        $this->assertTrue((bool) Student::where(['name' => $userData['name'],
            'lastname' => $userData['lastname'], 'date_birth' => $userData['date_birth']])->count());

        //Удаляем созданного студента из базы данных
        Student::where(['name' => $userData['name'],
            'lastname' => $userData['lastname'], 'date_birth' => $userData['date_birth']])->delete();
    }

    //Настройка конфигурации окружения
    protected function setUp(): void
    {
        //Установка переменной среды
        $_SERVER['DOCUMENT_ROOT'] = 'C:\xampp\htdocs';

        //Создаем экземпляр приложения
        $GLOBALS['app'] = new Src\Application(new Src\Settings([
            'app' => include $_SERVER['DOCUMENT_ROOT'] . "/praktika/config/app.php",
            'db' => include $_SERVER['DOCUMENT_ROOT'] . "/praktika/config/db.php",
            'path' => include $_SERVER['DOCUMENT_ROOT'] . "/praktika/config/path.php",
        ]));

        //Глобальная функция для доступа к объекту приложения
        if (!function_exists('app')) {
            function app()
            {
                return $GLOBALS['app'];
            }
        }
    }

    //Метод, возвращающий набор тестовых данных
    public function additionProvider(): array
    {
        return [
            ['GET', ['name' => '', 'lastname' => '', 'patronymic' => '', 'sex' => '', 'date_birth' => '',
                'address' => '', 'students_group' => ''],
                '<h3></h3>'
            ],
            ['POST', ['name' => '', 'lastname' => '', 'patronymic' => '', 'date_birth' => '', 'sex' => '',
                'address' => '', 'students_group' => ''],
                '<h3>{"name":["Поле name пусто"],"lastname":["Поле lastname пусто"],
                      "date_birth":["Поле date_birth пусто","Поле date_birth содержит некорректные данные для формы"],
                      "address":["Поле address пусто"],"students_group":["Поле students_group пусто",
                      "Поле students_group должно быть цифрой"]}</h3>'
            ],
            ['POST', ['name' => 'Остап', 'lastname' => 'Кузюра', 'patronymic' => 'Дмитриевич', 'date_birth' => '2003-02-28', 'sex' => '1',
                'address' => 'ооо', 'students_group' => 'group_in_base'],
                "<h3><p style='color: green'>Студент успешно добавлен!</p></h3>"
            ],
            ['POST', ['name' => 'Остап', 'lastname' => 'Кузюра', 'patronymic' => '', 'date_birth' => '20036-02-28', 'sex' => 'one',
                'address' => '', 'students_group' => '1'],
                '<h3>{"sex":["Поле sex должно быть цифрой"],
                      "date_birth":["Поле date_birth содержит некорректные данные для формы"],"address":["Поле address пусто"]}</h3>'
            ],
        ];
    }

}
