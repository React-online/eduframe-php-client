<?php

namespace Eduframe\Resources\Credits;

use Eduframe\Resource;

class Definition extends Resource
{

    protected array $fillable = [
        'id',
        'credits',
        'type'
    ];

    protected string $endpoint = 'credit_definitions';

    protected string $namespace = 'credit_definition';

    protected array $singleNestedEntities = [
        'type' => Type::class,
    ];
}
