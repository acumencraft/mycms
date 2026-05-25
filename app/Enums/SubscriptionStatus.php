<?php
namespace App\Enums;

enum SubscriptionStatus: string
{
    case Pending   = 'pending';
    case Active    = 'active';
    case Cancelled = 'cancelled';
    case Expired   = 'expired';

    public function label(): string
    {
        return match($this) {
            self::Pending   => 'Pending',
            self::Active    => 'Active',
            self::Cancelled => 'Cancelled',
            self::Expired   => 'Expired',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending   => 'warning',
            self::Active    => 'success',
            self::Cancelled => 'danger',
            self::Expired   => 'gray',
        };
    }
}
