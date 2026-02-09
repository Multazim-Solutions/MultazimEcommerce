<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Failed = 'failed';
    case Shipped = 'shipped';
    case Cancelled = 'cancelled';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Paid => 'Paid',
            self::Failed => 'Failed',
            self::Shipped => 'Shipped',
            self::Cancelled => 'Cancelled',
        };
    }

    public function badgeVariant(): string
    {
        return match ($this) {
            self::Paid => 'success',
            self::Failed => 'danger',
            self::Cancelled => 'warning',
            default => 'neutral',
        };
    }

    public function canTransitionTo(self $target): bool
    {
        if ($this === $target) {
            return true;
        }

        return match ($this) {
            self::Pending => in_array($target, [self::Paid, self::Failed, self::Cancelled], true),
            self::Paid => in_array($target, [self::Shipped, self::Cancelled], true),
            self::Failed, self::Shipped, self::Cancelled => false,
        };
    }
}
