<?php

namespace Eduframe\Resources\Credits;

use Eduframe\Resource;

class Category extends Resource
{

    protected array $fillable = [
        'id',
        'name'
    ];

    protected string $endpoint = 'credit_category';

    protected string $namespace = 'credit_category';
}
