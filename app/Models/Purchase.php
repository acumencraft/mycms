<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Purchase extends Model
{
    use HasFactory;

protected $fillable = [
    'user_id',
    'digital_product_version_id',
    'transaction_id',
    'amount',
    'download_expires_at',
    'download_limit',
    'license_key',
];
protected $casts = [
    'download_expires_at' => 'datetime',
];
protected static function booted()
{
    static::creating(function ($purchase) {
        $purchase->license_key = strtoupper(
            Str::random(8) . '-' . Str::random(8) . '-' . Str::random(8)
        );
    });
}
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function version()
    {
        return $this->belongsTo(DigitalProductVersion::class, 'digital_product_version_id');
    }

    public function product()
    {
        return $this->hasOneThrough(
            DigitalProduct::class,
            DigitalProductVersion::class,
            'id',
            'id',
            'digital_product_version_id',
            'digital_product_id'
        );
    }
}
