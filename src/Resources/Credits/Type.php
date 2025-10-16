<?php

namespace Eduframe\Resources\Credits;

use Eduframe\Resource;
use Eduframe\Resources\Category;

class Type extends Resource
{

    protected array $fillable = [
        'id',
        'name',
        'category'
    ];

    protected string $endpoint = 'credit_type';

    protected string $namespace = 'credit_type';

    protected array $singleNestedEntities = [
        'category' => Category::class,
    ];
}
