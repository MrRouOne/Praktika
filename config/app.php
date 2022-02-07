<?php
return [
    //Класс аутентификации
    'auth' => \Src\Auth\Auth::class,
    //Клас пользователя
    'identity' => \Model\User::class,
    //Классы для middleware
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'admin' => \Middlewares\AdminMiddleware::class,
        'personal' => \Middlewares\PersonalMiddleware::class,
        'curator' => \Middlewares\CuratorMiddleware::class,
    ],
    'routeAppMiddleware' => [
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'trim' => \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
    ],
    // Классы с валидацией
    'validators' => [
        'required' => \Validators\RequireValidator::class,
        'unique' => \Validators\UniqueValidator::class,
        'english' => \Validators\EnglishValidator::class,
        'russian' => \Validators\RussianValidator::class,
        'integer' => \Validators\IntValidator::class,
        'date' => \Validators\DateValidator::class,
        'semester' => \Validators\SemesterValidator::class,
    ]
];
