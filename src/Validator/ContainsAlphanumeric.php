<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class ContainsAlphanumeric extends Constraint
{
    public $message = 'The string "{{ string }}" contains invalid charecter';
}

