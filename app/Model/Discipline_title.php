<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Discipline_title extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];


    //Возврат первичного ключа
    public function getId(): int
    {
        return $this->id;
    }
}
