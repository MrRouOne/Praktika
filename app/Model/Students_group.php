<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;
use Src\Auth\Auth;

class Students_group extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'students_group');
    }

}
