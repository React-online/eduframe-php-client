<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Element extends Resource
{
    use FindAll, FindOne;

    protected array $fillable = [
        'id',
        'course_id',
        'edition_id',
        'planned_course_id',
        'position'
    ];
    protected string $endpoint = 'program/elements';

    protected string $namespace = 'element';
}
