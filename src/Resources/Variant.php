<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Variant extends Resource
{
    use FindAll, FindOne;
    
    protected array $fillable = [
        'id',
        'name',
        'updated_at',
        'created_at'
    ];
    protected string $endpoint = 'course_variants';

    protected string $namespace = 'course_variant';
}
