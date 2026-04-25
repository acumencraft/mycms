<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'user_id', 'subscription_plan_id', 'status',
        'starts_at', 'ends_at', 'next_invoice_at',
        'cancel_requested', 'notes',
    ];

    protected $casts = [
        'starts_at'        => 'date',
        'ends_at'          => 'date',
        'next_invoice_at'  => 'date',
        'cancel_requested' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }
}
