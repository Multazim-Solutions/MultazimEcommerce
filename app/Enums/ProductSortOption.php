<?php

declare(strict_types=1);

namespace App\Enums;

enum ProductSortOption: string
{
    case Newest = 'newest';
    case PriceLowToHigh = 'price_asc';
    case PriceHighToLow = 'price_desc';
    case NameAZ = 'name_asc';

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
            return self::Newest;
        }

        return self::tryFrom($value) ?? self::Newest;
    }

    public function label(): string
    {
        return match ($this) {
            self::Newest => 'Newest first',
            self::PriceLowToHigh => 'Price: low to high',
            self::PriceHighToLow => 'Price: high to low',
            self::NameAZ => 'Name: A to Z',
        };
    }
}
