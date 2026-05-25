<?php
namespace App\Enums;

enum ProjectStatus: string
{
    case Pending     = 'pending';
    case InProgress  = 'in_progress';
    case OnHold      = 'on_hold';
    case Completed   = 'completed';
    case Cancelled   = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::Pending    => 'Pending',
            self::InProgress => 'In Progress',
            self::OnHold     => 'On Hold',
            self::Completed  => 'Completed',
            self::Cancelled  => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pending    => 'warning',
            self::InProgress => 'info',
            self::OnHold     => 'gray',
            self::Completed  => 'success',
            self::Cancelled  => 'danger',
        };
    }
}
