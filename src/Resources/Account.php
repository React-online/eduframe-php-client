<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Account extends Resource
{
    use FindAll, FindOne;

    protected array $fillable = [
        'id',
        'name',
        'email',
        'account_type',
        'personal_user_id',
        'address',
        'signup_answers',
        'updated_at',
        'created_at'
    ];

    protected string $endpoint = 'accounts';

    protected string $namespace = 'account';

    protected array $singleNestedEntities = [
        'address' => Address::class,
    ];

    protected array $multipleNestedEntities = [
        'signup_answers' => [
            'entity' => SignupAnswer::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ]
    ];
}
