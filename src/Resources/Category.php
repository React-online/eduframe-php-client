<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Category extends Resource
{
    use FindAll, FindOne;

    protected array $fillable = [
        'id',
        'name',
        'slug',
        'position',
        'description',
        'avatar',
        'meta_title',
        'meta_description',
        'parent_id',
        'is_published',
        'updated_at',
        'created_at'
    ];

    protected string $endpoint = 'categories';

    protected string $namespace = 'category';
}
