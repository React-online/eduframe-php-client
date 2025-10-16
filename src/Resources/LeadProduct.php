<?php

namespace Eduframe\Resources;

use Eduframe\Resource;

class LeadProduct extends Resource
{

    protected array $fillable = [
        'catalog_product_id',
        'catalog_variant_id'
    ];

    protected string $endpoint = 'lead_products';
    protected string $namespace = 'lead_products';
}
