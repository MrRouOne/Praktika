<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class DisciplineTitle extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];


}
