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

    public static function getAbsoluteRoot(): string
    {
        global $app;
        return __DIR__ . "\\..\\..\\" . $app->settings->getUploadPath();
    }

    public static function getFileRoot(): string
    {
        global $app;
        return $app->settings->getUploadPath();
    }

    public static function checkUpload(string $filename): bool
    {
        $absolute_root = Report::getAbsoluteRoot() . $_FILES["$filename"]['name'];

        if (move_uploaded_file($_FILES["$filename"]['tmp_name'], $absolute_root)) {
            return 1;
        }
        return 0;
    }


}
