<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;
use Eduframe\Traits\Storable;

class Lead extends Resource
{
    use FindAll, FindOne, Storable;

    protected array $fillable = [
        'id',
        'title',
        'company_name',
        'first_name',
        'middle_name',
        'last_name',
        'administrator_id',
        'email',
        'phone',
        'status',
        'quality',
        'wants_newsletter',
        'comment',
        'website_url',
        'course_ids',
        'label_ids',
        'address',
        'labels',
        'courses_leads',
        'lead_products',
        'updated_at',
        'created_at'
    ];

    protected string $endpoint = 'leads';

    protected string $namespace = 'lead';

    protected array $singleNestedEntities = [
        'address' => Address::class,
    ];

    protected array $multipleNestedEntities = [
        'labels' => [
            'entity' => Label::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
        'courses_leads' => [
            'entity' => LeadInterest::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
        'lead_products' => [
            'entity' => LeadProduct::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
    ];
}
