<?php

namespace Validators;

use Illuminate\Database\Capsule\Manager as Capsule;
use Src\Validator\AbstractValidator;

class SemesterValidator extends AbstractValidator
{

    protected string $message = 'Field :field must not be more than 2';

    public function rule(): bool
    {
        if ((int) $this->value >2){
            return false;
        }
        return true;
    }
}
