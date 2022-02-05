<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class EnglishValidator extends AbstractValidator
{

    protected string $message = 'Field :field incorrect';

    public function rule(): bool
    {
        return preg_match('/^[A-Za-z0-9]+$/', $this->value);
    }
}
