<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Rate extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];


}
