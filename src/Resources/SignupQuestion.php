<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;

class SignupQuestion extends Resource
{
    use FindAll;

    protected array $fillable = [
        'id',
        'position',
        'field_type',
        'title',
        'required',
        'for_customer',
        'for_student',
        'choices'
    ];

    protected string $endpoint = 'signup_questions';

    protected string $namespace = 'signup_questions';
}
