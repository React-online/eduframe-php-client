<?php

namespace Eduframe\Resources;

use Eduframe\Resource;

class SignupAnswer extends Resource
{

    protected array $fillable = [
        'id',
        'signup_question_id',
        'value'
    ];

    protected string $endpoint = 'signup_answers';

    protected string $namespace = 'signup_answers';
}
