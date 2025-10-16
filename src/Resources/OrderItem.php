<?php

namespace Eduframe\Resources;

use Eduframe\Resource;

class OrderItem extends Resource
{

    protected array $fillable = [
        'student_id',
    ];

    protected string $endpoint = 'order_items';

    protected string $namespace = 'order_items';
}
