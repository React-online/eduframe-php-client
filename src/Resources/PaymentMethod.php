<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;

class PaymentMethod extends Resource
{
    use FindAll;

    protected array $fillable = [
        'id',
        'name',
        'gateway'
    ];

    protected string $endpoint = 'payment_methods';

    protected string $namespace = 'payment_methods';
}
