<?php

declare(strict_types=1);

namespace App\Data\Storefront;

use App\Enums\ProductSortOption;
use App\Enums\ProductStockFilter;

final readonly class ProductCatalogFilters
{
    public function __construct(
        public ?string $search,
        public ProductSortOption $sort,
        public ProductStockFilter $stock,
    ) {}

    public function hasSearch(): bool
    {
        return $this->search !== null && $this->search !== '';
    }
}
