<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductIndexRequest extends FormRequest
{
    private const SORT_OPTIONS = [
        'newest',
        'name_asc',
        'price_desc',
        'stock_low',
    ];

    private const STOCK_FILTERS = [
        'all',
        'in_stock',
        'out_of_stock',
    ];

    private const ACTIVE_FILTERS = [
        'all',
        'active',
        'inactive',
    ];

    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * @return array<string, array<int, \Illuminate\Contracts\Validation\ValidationRule|string>>
     */
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:120'],
            'sort' => ['nullable', Rule::in(self::SORT_OPTIONS)],
            'stock' => ['nullable', Rule::in(self::STOCK_FILTERS)],
            'active' => ['nullable', Rule::in(self::ACTIVE_FILTERS)],
        ];
    }

    public function search(): ?string
    {
        $value = $this->string('q')->trim()->value();

        return $value === '' ? null : $value;
    }

    public function sort(): string
    {
        $sort = $this->string('sort')->value();

        return in_array($sort, self::SORT_OPTIONS, true) ? $sort : 'newest';
    }

    public function stock(): string
    {
        $stock = $this->string('stock')->value();

        return in_array($stock, self::STOCK_FILTERS, true) ? $stock : 'all';
    }

    public function active(): string
    {
        $active = $this->string('active')->value();

        return in_array($active, self::ACTIVE_FILTERS, true) ? $active : 'all';
    }
}
