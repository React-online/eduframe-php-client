<?php

namespace Eduframe\Resources;

use Eduframe\Resource;
use Eduframe\Traits\FindAll;
use Eduframe\Traits\FindOne;

class CatalogProduct extends Resource
{
    use FindAll, FindOne;

    protected array $fillable = [
        'id',
        'name',
        'slug',
        'category_id',
        'productable_type',
        'productable_id',
        'is_published',
        'cost_scheme',
        'show_on_website',
        'cost',
        'position',
        'avatar',
        'conditions_or_default',
        'currency',
        'course_tab_contents',
        'custom',
        'label_ids',
        'signup_url',
        'updated_at',
        'created_at'
    ];

    protected string $endpoint = 'catalog/products';

    protected string $namespace = 'catalog_product';

    protected array $multipleNestedEntities = [
        'course_tab_contents' => [
            'entity' => CourseTabContent::class,
            'type'   => self::NESTING_TYPE_NESTED_OBJECTS,
        ],
    ];
}
