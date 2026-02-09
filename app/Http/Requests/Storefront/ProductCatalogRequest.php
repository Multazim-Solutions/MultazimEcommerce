<?php

declare(strict_types=1);

namespace App\Http\Requests\Storefront;

use App\Data\Storefront\ProductCatalogFilters;
use App\Enums\ProductSortOption;
use App\Enums\ProductStockFilter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCatalogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, \Illuminate\Contracts\Validation\ValidationRule|string>>
     */
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:120'],
            'sort' => ['nullable', Rule::in(ProductSortOption::values())],
            'stock' => ['nullable', Rule::in(ProductStockFilter::values())],
        ];
    }

    public function filters(): ProductCatalogFilters
    {
        $search = $this->string('q')->trim()->value();

        return new ProductCatalogFilters(
            search: $search === '' ? null : $search,
            sort: ProductSortOption::fromNullable($this->string('sort')->value()),
            stock: ProductStockFilter::fromNullable($this->string('stock')->value()),
        );
    }
}
