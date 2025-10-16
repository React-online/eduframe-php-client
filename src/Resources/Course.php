<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Resources\Credits\Definition;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Course extends Resource
{
    use FindAll, FindOne;

    protected array $fillable = [
        'id',
        'category_id',
        'slug',
        'name',
        'position',
        'meta_title',
        'meta_description',
        'code',
        'duration',
        'starting_price',
        'signup_url',
        'slug_history',
        'avatar',
        'level',
        'result',
        'conditions_or_default',
        'course_tab_contents',
        'credit_definitions',
        'labels',
        'is_published',
        'custom',
        'updated_at',
        'created_at'
    ];

    protected string $endpoint = 'courses';

    protected string $namespace = 'course';

    protected array $multipleNestedEntities = [
        'course_tab_contents' => [
            'entity' => CourseTabContent::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
        'credit_definitions' => [
            'entity' => Definition::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
        'labels' => [
            'entity' => Label::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
    ];
}
