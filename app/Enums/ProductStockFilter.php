<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductStockFilter: string
{
    case All = 'all';
    case InStock = 'in_stock';
    case OutOfStock = 'out_of_stock';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function fromNullable(?string $value): self
    {
        if ($value === null) {
            return self::All;
        }

        return self::tryFrom($value) ?? self::All;
    }

    public function label(): string
    {
        return match ($this) {
            self::All => 'All stock',
            self::InStock => 'In stock',
            self::OutOfStock => 'Out of stock',
        };
    }
}
