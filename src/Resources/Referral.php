<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;

class Referral extends Resource
{
    use FindAll;

    protected array $fillable = [
        'id',
        'name'
    ];
    protected string $endpoint = 'referrals';

    protected string $namespace = 'referrals';
}
