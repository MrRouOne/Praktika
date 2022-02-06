<?php

namespace Validators;

use Illuminate\Database\Capsule\Manager as Capsule;
use Src\Validator\AbstractValidator;

class IntValidator extends AbstractValidator
{

    protected string $message = 'Field :field must be unique';

    public function rule(): bool
    {
        return preg_match('/^[0-9]+$/', $this->value);
    }
}
