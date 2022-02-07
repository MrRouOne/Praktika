<?php

namespace Validators;

use Illuminate\Database\Capsule\Manager as Capsule;
use Src\Validator\AbstractValidator;

class DateValidator extends AbstractValidator
{

    protected string $message = 'Field :field must be correct';

    public function rule(): bool
    {

        return  preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$this->value);
    }
}
