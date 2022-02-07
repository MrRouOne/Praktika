<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Report extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public static function getRootReport(): string
    {
        global $app;
        return $app->settings->getUploadPath();

    }

}
