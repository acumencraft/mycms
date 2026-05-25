<?php
namespace App\Enums;

enum OrderStatus: string
{
    case Pending   = 'pending';
    case Contacted = 'contacted';
    case Accepted  = 'accepted';
    case Rejected  = 'rejected';
    case Completed = 'completed';

    public function label(): string
    {
        return match($this) {
            self::Pending   => 'Pending',
            self::Contacted => 'Contacted',
            self::Accepted  => 'Accepted',
            self::Rejected  => 'Rejected',
            self::Completed => 'Completed',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending   => 'warning',
            self::Contacted => 'info',
            self::Accepted  => 'success',
            self::Rejected  => 'danger',
            self::Completed => 'gray',
        };
    }
}
