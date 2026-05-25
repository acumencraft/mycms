<?php
namespace App\Enums;

enum UserStatus: string
{
    case Active  = 'active';
    case Pending = 'pending';
    case Blocked = 'blocked';

    public function label(): string
    {
        return match($this) {
            self::Active  => 'Active',
            self::Pending => 'Pending',
            self::Blocked => 'Blocked',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Active  => 'success',
            self::Pending => 'warning',
            self::Blocked => 'danger',
        };
    }
}
