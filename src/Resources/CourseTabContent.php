<?php

namespace Eduframe\Resources;

use Eduframe\Resource;

class CourseTabContent extends Resource
{

    protected array $fillable = [
        'content',
        'course_tab'
    ];
    protected string $endpoint = 'course_tab_contents';

    protected string $namespace = 'course_tab_content';

    protected array $singleNestedEntities = [
        'course_tab' => CourseTab::class,
    ];
}
