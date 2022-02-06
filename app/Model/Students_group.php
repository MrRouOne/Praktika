<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Students_group extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];


}
