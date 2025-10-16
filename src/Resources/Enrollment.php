<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Enrollment extends Resource
{
    use FindAll, FindOne;

    protected array $fillable = [
        'id',
        'student_id',
        'status',
        'comments',
        'graduation_state',
        'updated_at',
        'created_at'
    ];

    protected string $endpoint = 'enrollments';

    protected string $namespace = 'enrollment';
}
