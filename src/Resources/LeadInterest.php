<?php

namespace Eduframe\Resources;

use Eduframe\Resource;

class LeadInterest extends Resource
{

    protected array $fillable = [
        'id',
        'course_id',
        'planned_course_id'
    ];

    protected string $endpoint = 'courses_leads';
    protected string $namespace = 'courses_leads';
}
