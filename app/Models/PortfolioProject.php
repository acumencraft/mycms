<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'title',
        'slug',
        'description',
        'project_url',
        'technologies',
        'project_type',
        'completed_at',
        'is_featured',
        'is_published',
        'cover_image',
    ];

    protected $casts = [
        'technologies' => 'array',
        'is_featured' => 'boolean',
        'completed_at' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PortfolioImage::class);
    }
}
