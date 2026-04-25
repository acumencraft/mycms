<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'currency',
        'billing_cycle', 'features', 'is_active', 'sort',
    ];

    protected $casts = [
        'features'  => 'array',
        'is_active' => 'boolean',
        'price'     => 'decimal:2',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function getBillingLabelAttribute(): string
    {
        return match($this->billing_cycle) {
            'monthly'   => '/ month',
            'quarterly' => '/ quarter',
            'yearly'    => '/ year',
        };
    }
}
