<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Teacher extends Resource
{
    use FindAll, FindOne;

    protected $fillable = [
        'id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'address',
        'teacher_headline',
        'teacher_description',
        'employee_number',
        'slug',
        'avatar_url',
        'labels',
        'signup_answers',
        'custom',
        'updated_at',
        'created_at'
    ];
    protected string $endpoint = 'teachers';

    protected string $namespace = 'teacher';

    protected array $singleNestedEntities = [
        'address' => Address::class
    ];

    protected array $multipleNestedEntities = [
        'labels' => [
            'entity' => Label::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
    ];
}
