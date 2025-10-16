<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;

class PaymentOption extends Resource
{
    use FindAll;

    protected array $fillable = [
        'id',
        'name',
        'extra_cost',
        'percentage',
        'multiplier'
    ];

    protected string $endpoint = 'payment_options';

    protected string $namespace = 'payment_options';
}
