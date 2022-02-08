<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function academicPerformances()
    {
        return $this->hasMany(AcademicPerformance::class, 'student');
    }

}
