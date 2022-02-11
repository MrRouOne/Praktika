<?php
return [
    //Классы провайдеров
    'providers' => [
        'kernel' => \Providers\KernelProvider::class,
        'route' => \Providers\RouteProvider::class,
        'db' => \Providers\DBProvider::class,
        'auth' => \Providers\AuthProvider::class,
    ],
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
        'token' => \Middlewares\TokenMiddleware::class,
        'curatorApi' => \Middlewares\CuratorApiMiddleware::class,
    ],
    'routeAppMiddleware' => [
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
        'trim' => \Middlewares\TrimMiddleware::class,
        'json' => \Middlewares\JSONMiddleware::class,
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
