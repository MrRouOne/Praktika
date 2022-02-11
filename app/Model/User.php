<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\Auth;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->password = md5($user->password);
            $user->save();
        });
    }

    //Выборка пользователя по первичному ключу
    public function findIdentity(int $id)
    {
        return self::where('id', $id)->first();
    }

    //Возврат первичного ключа
    public function getId(): int
    {
        return $this->id;
    }


    //Возврат аутентифицированного пользователя
    public function attemptIdentity(array $credentials)
    {
        return self::where(['login' => $credentials['login'],
            'password' => md5($credentials['password'])])->first();
    }

    public function group()
    {
        return $this->hasOne(StudentsGroup::class, 'user');
    }

    public static function checkRoleCurrent(string $role): bool
    {
        if (Role::find(Auth::user()['role'])->code === "$role") {
            return true;
        }
        return false;
    }

    public static function checkRole($user,string $role): bool
    {
        if (Role::find($user['role'])->code === "$role") {
            return true;
        }
        return false;
    }



}
