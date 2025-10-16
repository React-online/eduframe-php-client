<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class Label extends Resource
{
    use FindAll, FindOne;

    protected $fillable = [
        'id',
        'name',
        'color',
        'model_type',
        'updated_at',
        'created_at'
    ];
    protected string $endpoint = 'labels';

    protected string $namespace = 'label';
}
