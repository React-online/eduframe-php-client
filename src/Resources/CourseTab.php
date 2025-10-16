<?php

namespace Eduframe\Resources;

use Eduframe\Resource;

class CourseTab extends Resource
{

    protected array $fillable = [
        'name',
        'position'
    ];
    protected string $endpoint = 'course_tabs';

    protected string $namespace = 'course_tab';

    protected array $singleNestedEntities = [
        'course_tab' => CourseTab::class,
    ];
}
