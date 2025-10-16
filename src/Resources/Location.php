<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Location extends Resource
{
    use FindAll, FindOne;

    protected array $fillable = [
        'id',
        'name',
        'address',
        'updated_at',
        'created_at'
    ];
    protected string $endpoint = 'course_locations';

    protected string $namespace = 'location';

    protected array $singleNestedEntities = [
        'address' => Address::class,
    ];
}
