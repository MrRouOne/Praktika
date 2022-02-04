<?php

namespace Src\Auth;

use Src\Session;
use Model\Role;

class Auth
{
    //Свойство для хранения любого класса, реализующего интерфейс IdentityInterface
    private static IdentityInterface $user;

    //Инициализация класса пользователя
    public static function init(IdentityInterface $user): void
    {
        self::$user = $user;
        if (self::user()) {
            self::login(self::user());
        }
    }

    //Вход пользователя по модели
    public static function login(IdentityInterface $user): void
    {
        self::$user = $user;
        Session::set('id', self::$user->getId());
    }

    //Аутентификация пользователя и вход по учетным данным
    public static function attempt(array $credentials): bool
    {
        if ($user = self::$user->attemptIdentity($credentials)) {
            self::login($user);
            return true;
        }
        return false;
    }

    //Возврат текущего аутентифицированного пользователя
    public static function user()
    {
        $id = Session::get('id') ?? 0;
        return self::$user->findIdentity($id);
    }

    //Проверка является ли текущий пользователь аутентифицированным
    public static function check(): bool
    {
        if (self::user()) {
            return true;
        }
        return false;
    }

    public static function checkAdmin(): bool
    {
        if (Role::where('id', self::user()['role'])->first()['code'] === 'admin') {
            return true;
        }
        return false;
    }

    public static function checkPersonal(): bool
    {
        if (Role::where('id', self::user()['role'])->first()['code'] === 'staff') {
            return true;
        }
        return false;
    }

    public static function checkCurator(): bool
    {
        if (Role::where('id', self::user()['role'])->first()['code'] === 'curator') {
            return true;
        }
        return false;
    }


    //Выход текущего пользователя
    public static function logout(): bool
    {
        Session::clear('id');
        return true;
    }

}
