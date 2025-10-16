<?php

namespace Eduframe\Resources;

use Eduframe\Resource;

class Address extends Resource
{
    protected array $fillable = [
        'id',
        'addressee',
        'address',
        'postal_code',
        'city',
        'country',
        'updated_at',
        'created_at'
    ];

    protected string $endpoint = 'addresses';

    protected string $namespace = 'address';
}
