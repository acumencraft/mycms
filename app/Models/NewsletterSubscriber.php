<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'name',
        'status',
        'unsubscribe_token',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($subscriber) {
            $subscriber->unsubscribe_token = Str::random(64);
            $subscriber->status = $subscriber->status ?? 'active';
        });
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function unsubscribeUrl(): string
    {
        return route('newsletter.unsubscribe', $this->unsubscribe_token);
    }
}
