<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class CatalogVariant extends Resource
{
    use FindAll, FindOne;

    protected array $fillable = [
        'id',
        'name',
        'product_id',
        'variantable_type',
        'variantable_id',
        'is_published',
        'cost_scheme',
        'show_on_website',
        'cost',
        'custom',
        'availability',
        'updated_at',
        'created_at',
        'available_places',
        'currency'
    ];

    protected string $endpoint = 'catalog/variants';

    protected string $namespace = 'catalog_variant';
}
