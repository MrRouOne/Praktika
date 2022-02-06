<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class RussianValidator extends AbstractValidator
{

    protected string $message = 'Field :field incorrect';

    public function rule(): bool
    {
        if (!empty($this->value)) {
            return preg_match('/^[йцукенгшщзхъфывапролджэячсмитьбюёЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮЁ ]+$/', $this->value);
        }
        return true;
    }
}
