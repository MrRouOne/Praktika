<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Student extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public static function get(string $fieldName, string $value): string
    {
        return Student::where($fieldName, $value)->get();
    }

}
