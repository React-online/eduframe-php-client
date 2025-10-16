<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Meeting extends Resource
{
    use FindAll, FindOne;

    protected array $fillable = [
        'id',
        'name',
        'planned_course_id',
        'description',
        'description_dashboard',
        'meeting_location_id',
        'start_date_time',
        'end_date_time',
        'updated_at',
        'created_at'
    ];

    protected string $endpoint = 'meetings';

    protected string $namespace = 'meeting';
}
