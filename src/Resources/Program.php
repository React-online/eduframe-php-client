<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Program extends Resource
{
    use FindAll, FindOne;

    protected array $fillable = [
        'id',
        'category_id',
        'name',
        'slug',
        'cost',
        'conditions',
        'is_published',
        'course_tab_contents',
        'labels',
        'custom',
        'signup_url',
        'updated_at',
        'created_at'
    ];
    protected string $endpoint = 'program/programs';

    protected string $namespace = 'program';

    protected array $multipleNestedEntities = [
        'course_tab_contents' => [
            'entity' => CourseTabContent::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
        'labels' => [
            'entity' => Label::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
    ];
}
